<?php


namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => '123',
            'is_verified' => 1
        ]);

        $role = Role::where('name', 'Admin')->first();

        $user->assignRole([$role->id]);
    }
}
