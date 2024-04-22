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
            'name' => 'admin',
            'password' => '123',
            'status' => 1,
            'user_type' => 1,
            'email_verified_at' => now(),
        ]);

        $role = Role::where('name', 'Admin')->first();

        $user->assignRole([$role->id]);
    }
}
