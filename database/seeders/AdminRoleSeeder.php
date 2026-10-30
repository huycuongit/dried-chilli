<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class AdminRoleSeeder extends Seeder
{
    public function run()
    {
        $email = 'admin@jojomarket.com';
        $password = getenv('ADMIN_SEED_PASSWORD');
        if (!is_string($password) || strlen($password) < 8) {
            throw new RuntimeException('Set ADMIN_SEED_PASSWORD to a password of at least 8 characters before running this seeder.');
        }

        DB::transaction(function () use ($email, $password) {
            $matches = Admin::where('user_name', 'Admin')->orWhere('email', $email)->lockForUpdate()->get();
            if ($matches->count() > 1) {
                throw new RuntimeException('Multiple admin accounts match. Resolve the account conflict before running this seeder.');
            }

            $admin = $matches->first() ?? new Admin();
            $admin->forceFill([
                'name' => $admin->name ?: 'Administrator',
                'user_name' => 'Admin',
                'email' => $email,
                'type' => 1,
                'status' => 1,
                'active' => 1,
                'no_remove' => true,
                'remember_token' => Str::random(60),
            ]);
            $admin->password = $password;
            $admin->save();

            $role = Role::where('name_key', 'ADMIN')->first();
            if ($role) $admin->roles()->syncWithoutDetaching([$role->id]);
        });
    }
}
