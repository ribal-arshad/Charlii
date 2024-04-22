<?php

namespace App\Interfaces;

interface ManageRoleRepositoryInterface
{
    public function getAllRoles();

    public function getRoleById($roleId);

    public function createRole($roleDetails);

    public function updateRole($roleId, $roleDetails);

    public function changeStatus($roleId);
}
