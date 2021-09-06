<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::firstOrCreate(['title' => 'New Year', 'details' => '', 'start_at' => '2020-01-01'], []);
        Event::firstOrCreate(['title' => 'Mid month', 'details' => '', 'start_at' => '2020-01-15', 'end_at' => '2020-01-15'], []);
        Event::firstOrCreate(['title' => 'Long Week', 'details' => '<strong>Lonnggggg</strong> week', 'start_at' => '2020-01-20', 'end_at' => '2020-01-25'], []);
        Event::firstOrCreate(['title' => 'Overlap month', 'details' => 'Test overlap', 'start_at' => '2020-01-30', 'end_at' => '2020-02-03'], []);
    }
}
