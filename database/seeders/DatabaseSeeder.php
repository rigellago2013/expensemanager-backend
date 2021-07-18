<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seed Users Table
         */
        DB::table('users')->insert([
            [
                'name' =>  'admin',
                'email' =>  'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role_id' => Config::get('constants.roles.administrator'),
                'created_at' => Carbon::now()
            ],
            [
                'name' =>  'John Doe',
                'email' =>  'johndoe@example.com',
                'password' => Hash::make('johndoe'),
                'role_id' => Config::get('constants.roles.user'),
                'created_at' => Carbon::now()
            ],
        ]);

        /**
         * Seed Roles Table
         */
        DB::table('roles')->insert([
            [
                'display_name' =>  'Administrator',
                'description' => 'System Admin',
                'created_at' => Carbon::now()
            ],
            [
                'display_name' =>  'User',
                'description' => 'Can access expenses',
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
