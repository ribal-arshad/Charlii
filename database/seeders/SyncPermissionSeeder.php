<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncPermissionSeeder extends Seeder
{
    const DATA = [
        "Admin" => [
            "admin.login",
            "admin.login.data",
            "admin.forgot.password",
            "admin.forgot.password.data",
            "admin.reset.password",
            "admin.reset.password.data",
            "admin.logout",
            "dashboard",
            "manage.users",
            "user.add",
            "user.add.data",
            "user.update",
            "user.update.data",
            "user.detail",
            "user.delete"
        ]
    ];

    public function run(){
        $roles = Role::get();

        foreach ($roles as $role) {
            if ($role->name === 'User') {
                $role->syncPermissions([]);
            } elseif ($role->name === 'Admin') {
                $role->syncPermissions(Permission::pluck('id')->all());
            }
        }
    }
}
