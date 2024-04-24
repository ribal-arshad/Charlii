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
        "user.change.status",
        "user.update.data",
        "user.detail",
        "user.delete",
        "role.access",
        "role.add",
        "role.edit",
        "role.delete",
        "role.status.update",
        "role.detail",
        "user.gallery.access",
        "user.gallery.status.update",
        "user.gallery.add",
        "user.gallery.edit",
        "user.gallery.detail",
        "user.gallery.delete",
        "color.access",
        "color.status.update",
        "color.add",
        "color.edit",
        "color.detail",
        "color.delete",
        "calendar.access",
        "calendar.add",
        "calendar.edit",
        "calendar.detail",
        "calendar.delete",
        "series.access",
        "series.add",
        "series.edit",
        "series.detail",
        "series.status.update",
        "series.delete",
    ];

    public function run(){
        foreach (self::DATA as $val) {
            permission::create(['name' => $val]);
        }
    }
}
