<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Group;
use App\User;
use App\Role;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->regexify('[A-Z]-[1-9]'),
        'adviser_id' => User::where('role_id', Role::where('code', 'adviser')->first()->id)->get()->random()->id
    ];
});
