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
        factory(\App\Group::class, 40)->create();

        //create faker for random dates
        $faker = \Faker\Factory::create();

        //60 percent of groups reach milestone one (40 * 0,6 = 24)
        App\Group::all()->random(24)->each(function ($group) use ($faker) { 
            $group->milestones()->attach(1, [
                'done_on' => $faker->dateTimeBetween('2019-11-05 00:00:00', '2019-11-21 00:00:00'),
            ]);
            $group->save();
        });

        //60 percent of groups with milestone one reach milestone two (24 * 0,75 = 18)
        App\Group::with('milestones')->get()->random(18)->each(function ($group) use ($faker) { 
            $group->milestones()->attach(2, [
                'done_on' => $faker->dateTimeBetween('2020-01-10 00:00:00', '2020-01-17 00:00:00'),
            ]);
            $group->save();
        });
    }
}
