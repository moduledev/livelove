<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'test name','phone' => '3809999999999']);
        User::create(['name' => 'test name1','phone' => '3809999999998']);
        User::create(['name' => 'test name2','phone' => '3809999999997']);
        User::create(['name' => 'test name3','phone' => '3809999999996']);
        User::create(['name' => 'test name4','phone' => '3809999999995']);
    }
}
