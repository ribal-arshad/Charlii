<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUser();

    public function getUserById($userId);

    public function deleteUser($userId);

    public function createUser(array $userDetails);

    public function updateUser($userId, array $updatedDetails);
}
