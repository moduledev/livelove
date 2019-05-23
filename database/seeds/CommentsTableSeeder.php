<?php

use App\Comment;
use App\Program;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $programs = Program::all()->pluck('id');

       foreach ($programs as $id){
           Comment::create(['body' => 'test body','commentable_id' => $id,'commentable_type' => 'App\Program']);
       }


    }
}
