<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
use Hash;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('user_types')->insert([
        'user_role' => 'admin',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);

       DB::table('user_types')->insert([
        'user_role' => 'student',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);

       DB::table('user_types')->insert([
        'user_role' => 'instructor',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);

       DB::table('user_types')->insert([
        'user_role' => 'content_creator',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);

       DB::table('users')->insert([
        'firstname' => 'Enlilt',
        'lastname' => 'Admin',
        'email' => 'support@enlilt.com',
        'password' => Hash::make('enlilt@123'),
        'role_id' => 1,
        'deleted_at' => null,
        'image' => 'user.png',
        'timezone' => 'UTC',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);
    }
}
