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
        Event::updateOrCreate(['title' => 'New Year', 'details' => '', 'start_at' => '2020-01-01'], []);
        Event::updateOrCreate(['title' => 'Image example', 'details' => '<img src="http://memesvault.com/wp-content/uploads/You-Mad-Bro-Meme-Face-01.jpg"></img>', 'start_at' => '2020-10-15', 'end_at' => '2020-10-15'], []);
        Event::updateOrCreate(['title' => 'Vacation Week', 'details' => '<strong>Lonnggggg</strong> holiday', 'start_at' => '2020-10-25', 'end_at' => '2020-10-29'], []);
        Event::updateOrCreate(['title' => 'Overlap month', 'details' => 'Test overlap', 'start_at' => '2020-11-05', 'end_at' => '2020-11-15'], []);
    }
}
