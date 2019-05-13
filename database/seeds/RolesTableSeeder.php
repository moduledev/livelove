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

        $permissions = \Spatie\Permission\Models\Permission::all()->pluck('name');
        $role =  Role::updateOrCreate(['name' => 'super-admin']);

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }


       if(!Admin::where('email','admin@admin.com')->get()){
           $user = Admin::updateOrCreate(['name' => 'admin','email' => 'admin@admin.com','password' => Hash::make('password')]);
           $user->assignRole('super-admin');
       }

    }
}
