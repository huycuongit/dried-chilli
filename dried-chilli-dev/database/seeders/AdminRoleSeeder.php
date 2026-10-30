<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Admin;

class AdminRoleSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        $admin1 = Admin::updateOrInsert(
            ['email' => 'admin@feb.com'],
            [
                'name' => 'Quản Trị Viên',
                'user_name' => 'Admin',
                'password' => Hash::make('Feb@123'),
                'type' => 1,
                'status' => 1,
                'no_remove' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );


        // Get roles Admin and HR
        $adminRole = Role::where('name_key', 'ADMIN')->first();
        // Get ID of Admin and HR just created
        $admin = Admin::where('email', 'admin@feb.com')->first();
        // Swap role for account
        $admin->roles()->sync(
            ['role_id' => $adminRole->id]
        );
    }
}
