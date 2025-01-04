<?php

namespace App\Services;

use App\Models\User;
use Throwable;

class UserService
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $users = $this->userModel->getAll($filter, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $users
        ];
    }

    public function getById(int $id)
    {
        $user = $this->userModel->getById($id);

        if (empty($user)) {
            return [
                'status' => false,
                'data' => null
            ];
        }

        return [
            'status' => true,
            'data' => $user
        ];
    }

    public function create(array $payload)
    {
        try {
            $user = $this->userModel->store($payload);

            return [
                'status' => true,
                'data' => $user
            ];
        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    public function update(array $payload, int $id)
    {
        try {
            $this->userModel->edit($payload, $id);
            $user = $this->getById($id);

            return [
                'status' => true,
                'data' => $user['data']
            ];
        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $this->userModel->drop($id);

            return true;
        } catch (Throwable $th) {
            return false;
        }
    }
}
