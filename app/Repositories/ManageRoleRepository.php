<?php

namespace App\Repositories;

use App\Interfaces\ManageRoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class ManageRoleRepository implements ManageRoleRepositoryInterface
{
    public function getAllRoles()
    {
        return Role::where('id', '<>', 1)->get();
    }

    public function getRoleById($roleId)
    {
        return Role::findOrFail($roleId);
    }

    public function createRole($req)
    {
        $role = Role::create([
            'name' => $req->name,
            'guard_name' => 'web',
            'status' => $req->status,
        ]);

        $role->syncPermissions($req['permissions']);

        return redirect()->route('manage.roles')->with('success_msg', 'Role successfully added.');
    }

    public function updateRole($roleId, $req)
    {
        $role = Role::where('id', $roleId)->first();

        if(!empty($role)){

            $role->update([
                'name' => $req['name'],
                'status' => $req['status'],
            ]);

            $role->syncPermissions($req['permissions']);

            return redirect()->route('manage.roles')->with('success_msg', 'Role successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Role not found.');
    }

    public function getDataTable(){

        $query = Role::whereNotIn('name', ['Admin'])->orderBy('id', 'desc');

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function($w) use ($search){
                        $w->orWhere('name', 'LIKE', "%$search%");

                        if(strtolower($search) === "active"){
                            $w->orWhere('status', 1);
                        }elseif(strtolower($search) === "inactive"){
                            $w->orWhere('status', 0);
                        }

                    });
                }
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('role.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('role.change.status', $obj->id) . '`)" />
                                            <span class="switch-toggle-slider">
                                              <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                              </span>
                                              <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                              </span>
                                            </span>
                                        </label>';
                } else {
                    $switchBtn = $obj->status === 1 ? 'Active' : 'Inactive';
                }

                return $switchBtn;
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<div class="btn-group">';
                if(auth()->user()->can('role.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('role.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('role.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('role.update', $obj->id) . '">Edit</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['role_permissions', 'status', 'action'])->make(true);
    }

    public function changeStatus($roleId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $role = $this->getRoleById($roleId);

        if (!empty($role)) {
            $role->update([
                'status' => !$role->status
            ]);
            $msg = "Role status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }

    public function getRoutePermissions()
    {
        $routes = Route::getRoutes();
        $groupAdminRoutes = [];

        foreach ($routes as $route)
        {
            if(str_contains($route->getPrefix(), 'admin'))
            {
                $prefix = explode('admin/',$route->getPrefix());
                $groupAdminRoutes[$prefix[1]][] = $route->getName();

                Permission::updateOrCreate([
                    "name" => $route->getName(),
                    "guard_name" => "web",
                ],[
                    "name" => $route->getName(),
                    "guard_name" => "web",
                ]);

            }
        }
        return $groupAdminRoutes;
    }

    public function getActiveRolesToCreateUser()
    {
        return Role::where('id', '<>', 1)->where('status', 1)->get();
    }
}
