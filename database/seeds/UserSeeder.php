<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create a lecturer 
        User::create([
            'surname' => "Mustermann",
            'first_name' => "Max",
            'email' => "mail@example.com",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'api_token' => "GUUYBjQZLqEEHNbR3PE4yk86460kYfe9VO7NBF8t0l21nTxKDtXCcHyds9GK",
            'role_id' => 1,
        ]);

        //create a adviser 
        User::create([
            'surname' => "Musterfrau",
            'first_name' => "Anna",
            'email' => "anna@example.com",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'api_token' => "GUUYBjQZLqEEHNbR3PE4yk86460kYfe9VO7NBF8t0l21nTxKDtXCcHyds9GK1111",
            'role_id' => 2,
        ]);

        factory(\App\User::class, 4)->create();
    }
}
