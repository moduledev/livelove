<?php

use App\Admin;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role =  Role::create(['name' => 'super-admin']);

        $role->givePermissionTo('role-list');
        $role->givePermissionTo('role-create');
        $role->givePermissionTo('role-edit');
        $role->givePermissionTo('role-delete');
        $role->givePermissionTo('role-assign');
        $role->givePermissionTo('role-revoke');
        $role->givePermissionTo('role-show');

        $role->givePermissionTo('user-list');
        $role->givePermissionTo('user-create');
        $role->givePermissionTo('user-edit');
        $role->givePermissionTo('user-delete');
        $role->givePermissionTo('user-show');

        $role->givePermissionTo('admin-list');
        $role->givePermissionTo('admin-create');
        $role->givePermissionTo('admin-edit');
        $role->givePermissionTo('admin-delete');
        $role->givePermissionTo('admin-show');

        $role->givePermissionTo('program-list');
        $role->givePermissionTo('program-create');
        $role->givePermissionTo('program-edit');
        $role->givePermissionTo('program-delete');
        $role->givePermissionTo('program-show');

        $user = Admin::create(['name' => 'admin','email' => 'admin@admin.com','password' => Hash::make('password')]);
        $user->assignRole('super-admin');
    }
}
