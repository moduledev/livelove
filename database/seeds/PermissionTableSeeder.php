<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
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
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-assign',
            'role-revoke',
            'role-show',
            'user-list',
            'user-show',
            'user-create',
            'user-edit',
            'user-delete',
            'admin-list',
            'admin-show',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'program-list',
            'program-show',
            'program-create',
            'program-edit',
            'program-delete',
            'program-assign',
            'program-revoke',
            'permission-assign',
            'permission-revoke',
        ];

//        foreach ($permissions as $permission) {
//            Permission::where(['name' => $permission])->delete();
//        }

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
