<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomTimezone;

class TimezoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = time();
        foreach (timezone_identifiers_list() as $zone) {
            date_default_timezone_set($zone);
            $zones['offset'] = date('P', $timestamp);
            $zones['diff_from_gtm'] = 'UTC/GMT '.date('P', $timestamp);

            CustomTimezone::updateOrCreate(['name' => $zone], $zones);
        }
    }
}
