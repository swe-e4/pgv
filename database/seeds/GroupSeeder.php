<?php

use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Group::class, 16)->create();

        //create faker for random dates
        $faker = \Faker\Factory::create();

        //60 percent of groups reach milestone one (16 * 0,75 = 12)
        App\Group::all()->random(12)->each(function ($group) use ($faker) { 
            $group->milestones()->attach(1, [
                'done_on' => $faker->dateTimeBetween('2019-11-05 00:00:00', '2019-11-21 00:00:00'),
            ]);
            $group->save();
        });

        //60 percent of groups with milestone one reach milestone two (12 * 0,25 = 3)
        App\Group::with('milestones')->get()->random(3)->each(function ($group) use ($faker) { 
            $group->milestones()->attach(2, [
                'done_on' => $faker->dateTimeBetween('2020-01-10 00:00:00', '2020-01-17 00:00:00'),
            ]);
            $group->save();
        });
    }
}
