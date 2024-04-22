<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    const DATA = [
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
    ];

    public function run(){
        foreach (self::DATA as $val) {
            permission::create(['name' => $val]);
        }
    }
}
