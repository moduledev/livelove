<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionnewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'permission-assign',
            'permission-revoke',
            'program-assign',
            'program-revoke',
            'program-show',
            'role-assign',
            'role-revoke',
            'role-show',
            'user-show',
            'admin-show',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
