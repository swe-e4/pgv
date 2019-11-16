<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create lecturer role 
        Role::create([
            'code' => "lecturer",
        ]);
        
        //create adviser role 
        Role::create([
            'code' => "adviser",
        ]);
    }
}
