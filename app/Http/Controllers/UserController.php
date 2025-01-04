<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="Retrieve a list of users",
     *     description="Get all users with optional filters",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter users by name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Filter users by email",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="Filter users by phone number",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="active_status",
     *         in="query",
     *         description="Filter users by active status",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="department",
     *         in="query",
     *         description="Filter users by department",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UserCollection")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $filter = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'phone_number' => $request->phone_number ?? '',
            'active_status' => isset($request->active_status) ? $request->active_status : '',
            'department' => $request->department ?? ''
        ];

        $users = $this->userService->getAll($filter, $request->per_page ?? 25, $request->sort ?? '');

        return response()->json([
            "message" => "All users retrieved successfully",
            "data" => new UserCollection($users['data'])
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     summary="Retrieve a user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show($id)
    {
        $user = $this->userService->getById($id);

        if (!($user['status'])) {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        return response()->json([
            "message" => "User retrived successfully",
            "data" => $user['data']
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="phone_number", type="string", example="123456789"),
     *             @OA\Property(property="active_status", type="integer", example=1),
     *             @OA\Property(property="department", type="string", example="IT")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation errors"
     *     )
     * )
     */
    public function store(UserRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                "message" => $request->validator->errors()
            ], 400);
        }

        $payload = $request->only([
            'name',
            'email',
            'phone_number',
            'active_status',
            'department'
        ]);

        $user = $this->userService->create($payload);

        if (!$user['status']) {
            return response()->json([
                "message" => $user['error']
            ], 400);
        }

        return response()->json([
            "message" => "User created successfully",
            "data" => $user['data']
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/users",
     *     summary="Update user by id",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example="1"),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="phone_number", type="string", example="123456789"),
     *             @OA\Property(property="active_status", type="integer", example=1),
     *             @OA\Property(property="department", type="string", example="IT")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation errors"
     *     )
     * )
     */
    public function update(UserRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                "message" => $request->validator->errors()
            ], 400);
        }

        $payload = $request->only([
            'id',
            'name',
            'email',
            'phone_number',
            'active_status',
            'department'
        ]);

        $user = $this->userService->update($payload, $payload['id']);

        if (!$user) {
            return response()->json([
                "message" => $user['error']
            ], 404);
        }

        return response()->json([
            "message" => "User updated successfully",
            "data" => $user['data']
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     summary="Delete a user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $user = $this->userService->delete($id);

        if (!$user) {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }

        return response()->json([
            "message" => "User deleted successfully"
        ], 200);
    }
}
