<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class AchievementBadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('achievement_badges')->insert([
            'title' => 'Joinee',
            'image' => 'Badge 1.svg',
            'description' => 'The "Joinee" badge is awarded to you when you enroll to a course.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ]);


           DB::table('achievement_badges')->insert([
            'title' => 'Starter',
            'image' => 'Badge 2.svg',
            'description' => 'The "Starter" badge is assigned to you when you start with your first Live Session.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ]);


           DB::table('achievement_badges')->insert([
            'title' => 'Assignment',
            'image' => 'Badge 3.svg',
            'description' => 'This badge is awarded to you when you submit your first assignment for this course.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ]);


           DB::table('achievement_badges')->insert([
            'title' => 'Q&A',
            'image' => 'Badge.svg',
            'description' => 'This badge is awarded to you when you actively participate in the Q/A section of this course.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ]);


           DB::table('achievement_badges')->insert([
            'title' => 'Completion',
            'image' => 'Completion.svg',
            'description' => 'This badge is awarded to you when you have completed a course.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ]);
    }
}
