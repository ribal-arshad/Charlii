<?php

namespace App\Interfaces;

interface ManageUserRepositoryInterface
{
    public function getAllUser();

    public function getUserById($userId);

    public function deleteUser($userId);

    public function createUser($userDetails);

    public function updateUser($userId, $updatedDetails);
}
