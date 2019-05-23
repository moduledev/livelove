<?php

use Illuminate\Database\Seeder;

class FakeLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = [
            'Dnepr',
            'Kyiv',
            'Herson',
            'Herson',
            'Lviv',
        ];

        $programs = \App\Program::all();

        foreach ($programs as $program){
            if($program->location ===  null){
                $program->location = $location[array_rand($location, 1)];
                $program->save();
            }
        }
    }
}
