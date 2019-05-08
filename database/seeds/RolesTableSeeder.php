<?php

use Illuminate\Database\Seeder;
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

        $role->givePermissionTo('user-list');
        $role->givePermissionTo('user-create');
        $role->givePermissionTo('user-edit');
        $role->givePermissionTo('user-delete');

        $role->givePermissionTo('admin-list');
        $role->givePermissionTo('admin-create');
        $role->givePermissionTo('admin-edit');
        $role->givePermissionTo('admin-delete');

        $role->givePermissionTo('program-list');
        $role->givePermissionTo('program-create');
        $role->givePermissionTo('program-edit');
        $role->givePermissionTo('program-delete');

    }
}
