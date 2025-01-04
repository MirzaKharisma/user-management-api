<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User Schema",
 *     description="Schema for User entity",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *     @OA\Property(property="phone_number", type="string", example="123456789"),
 *     @OA\Property(property="active_status", type="boolean", example=true),
 *     @OA\Property(property="department", type="string", example="HR")
 * )
 *
 * @OA\Schema(
 *     schema="UserCollection",
 *     type="object",
 *     title="User Collection Schema",
 *     description="A collection of User objects",
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         example="All users retrieved successfully"
 *     ),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/User")
 *     )
 * )
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    public $timestamps = true;

    /**
     * Menentukan nama tabel yang terhubung dengan Class ini
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'active_status',
        'department'
    ];

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $user = $this->query();

        if (!empty($filter['name'])) {
            $user->where('name', 'LIKE', '%' . $filter['name'] . '%');
        }

        if (!empty($filter['email'])) {
            $user->where('email', 'LIKE', '%' . $filter['email'] . '%');
        }

        if (!empty($filter['phone_number'])) {
            $user->where('phone_number', 'LIKE', '%' . $filter['phone_number'] . '%');
        }

        if ($filter['active_status'] != '') {
            $user->where('active_status', '=', $filter['active_status']);
        }

        if (!empty($filter['department'])) {
            $user->where('department', 'LIKE', '%' . $filter['department'] . '%');
        }

        $sort = $sort ?: 'id DESC';
        $user->orderByRaw($sort);
        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false;

        return $user->paginate($itemPerPage)->appends('sort', $sort);
    }

    public function getById(int $id)
    {
        return $this->query()->find($id);
    }

    public function store(array $payload)
    {
        return $this->query()->create($payload);
    }

    public function edit(array $payload, int $id)
    {
        return $this->query()->find($id)->update($payload);
    }

    public function drop(int $id)
    {
        return $this->query()->find($id)->delete();
    }
}
