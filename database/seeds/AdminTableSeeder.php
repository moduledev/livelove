<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = Admin::create(['name' => 'admin','email' => 'admin@admin.com','password' => Hash::make('password')]);
        $user->givePermissionTo('admin-list');
        $user->givePermissionTo('admin-create');
        $user->givePermissionTo('admin-edit');
        $user->givePermissionTo('admin-delete');

        $user->givePermissionTo('user-list');
        $user->givePermissionTo('user-create');
        $user->givePermissionTo('user-edit');
        $user->givePermissionTo('user-delete');

        $user->givePermissionTo('role-list');
        $user->givePermissionTo('role-create');
        $user->givePermissionTo('role-edit');
        $user->givePermissionTo('role-delete');

        $user->givePermissionTo('program-list');
        $user->givePermissionTo('program-create');
        $user->givePermissionTo('program-edit');
        $user->givePermissionTo('program-delete');
    }
}
