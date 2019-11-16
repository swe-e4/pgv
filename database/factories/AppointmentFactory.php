<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Appointment;
use App\Group;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    $startTime = (int)(time() + $faker->unique()->numberBetween(60*60*24*2,60*60*24*60));
    $group = Group::all()->random();
    return [
        'name' => $group->name.' #'.$faker->numberBetween(1,100),
        'start' => Carbon::parse($startTime)->format('Y-m-d H:i:s'),
        'end' => Carbon::parse((int)($startTime + 60*60*1.5))->format('Y-m-d H:i:s'),
        'group_id' => $group->id,
        'description' => $faker->text($faker->numberBetween(100,400)),
        'traffic_light_status' => $faker->randomElement(['red', 'yellow', 'green']),
        'rating' => $faker->randomElement(['+', '0', '-']),
    ];
});
