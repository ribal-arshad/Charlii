<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Interfaces\ManageRoleRepositoryInterface;

class ManageRoleController extends Controller
{
    private ManageRoleRepositoryInterface $manageRoleRepository;

    public function __construct(ManageRoleRepositoryInterface $manageRoleRepository)
    {
        $this->manageRoleRepository = $manageRoleRepository;
    }

    public function manageRoles()
    {
        if (request()->ajax()) {
            return $this->manageRoleRepository->getDataTable();
        }

        return view('manage-role.index');
    }

    public function addRole()
    {
        $permissions = $this->manageRoleRepository->getRoutePermissions();
        return view('manage-role.add', ['permissions' => $permissions]);
    }

    public function addRoleData(RoleStoreRequest $request)
    {
        return $this->manageRoleRepository->createRole($request);
    }

    public function updateRole($roleId)
    {
        $permissions = $this->manageRoleRepository->getRoutePermissions();
        $role = $this->manageRoleRepository->getRoleById($roleId);

        if (!empty($role)) {
            return view('manage-role.update',[
                'role' => $role,
                'permissions' => $permissions,
            ]);
        }

        abort(404);
    }

    public function updateRoleData($roleId, RoleUpdateRequest $request)
    {
        return $this->manageRoleRepository->updateRole($roleId, $request);
    }

    public function getRoleDetail($roleId)
    {
        $role = $this->manageRoleRepository->getRoleById($roleId);
        return view('manage-role.detail', ['role' => $role]);
    }

    public function changeRoleStatus($roleId)
    {
        return $this->manageRoleRepository->changeStatus($roleId);
    }
}
