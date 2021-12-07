<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('filters')->insert([
        'filter_name' => 'Category',
        'is_enabled' => false,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);

       DB::table('filters')->insert([
        'filter_name' => 'Difficulty',
        'is_enabled' => false,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);

       DB::table('filters')->insert([
        'filter_name' => 'Ratings',
        'is_enabled' => false,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);

       DB::table('filters')->insert([
        'filter_name' => 'Duration',
        'is_enabled' => false,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);

       DB::table('filters')->insert([
        'filter_name' => 'Instructor',
        'is_enabled' => false,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);
    }
}
