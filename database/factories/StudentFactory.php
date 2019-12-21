<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use App\Group;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'surname' => $faker->lastName,
        'first_name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'student_number' => $faker->unique()->numberBetween(100000, 99999999),
        'group_id' => Group::all()->random()->id,
    ];
});
