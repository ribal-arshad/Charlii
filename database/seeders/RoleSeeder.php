<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    const ROLES = [
        'Admin'
    ];

    public function run()
    {
        foreach (self::ROLES as $value){
            Role::create(['name' => $value]);
        }

    }
}
