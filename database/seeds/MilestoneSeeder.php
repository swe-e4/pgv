<?php

use Illuminate\Database\Seeder;
use App\Milestone;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create delivery of the specification book
        Milestone::create([
            'name' => "Abgabe vom Lastenheft",
            'deadline' => "2019-12-01"
        ]);
        
        //create delivery of the project
        Milestone::create([
            'name' => "Abgabe vom Projekt",
            'deadline' => "2020-01-25"
        ]);
    }
}
