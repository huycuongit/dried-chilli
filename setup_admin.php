<?php
$role = \App\Models\Role::firstOrCreate(['name' => 'Super Admin']);
$admin = \App\Models\Admin::where('email', 'admin@feb.com')->first();
if (!$admin) {
    $admin = new \App\Models\Admin();
    $admin->email = 'admin@feb.com';
}
$admin->name = 'Admin User';
$admin->user_name = 'Admin';
$admin->password = '12345678';
$admin->type = 1;
$admin->status = 1;
$admin->active = 1;
$admin->save();

$admin->roles()->sync([$role->id]);
echo "SUCCESS: Admin created! Email: admin@feb.com | Password: 12345678\n";
