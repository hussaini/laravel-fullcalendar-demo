<?php

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
    	// clean table 'events'
        DB::table('events')->delete();
 
 		// specify the value to be insert to table 'events'
        $events = array(
            ['title' => 'New Year', 'details' => '', 'start' => '2016-01-01', 'end' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['title' => 'Image example', 'details' => '<img src="http://memesvault.com/wp-content/uploads/You-Mad-Bro-Meme-Face-01.jpg"></img>', 'start' => '2016-01-15', 'end' => '2016-01-15', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['title' => 'Vacation Week', 'details' => '<strong>Lonnggggg</strong> holiday', 'start' => '2016-01-25', 'end' => '2016-01-29', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        );

		// insert data into table 'events' 
        DB::table('events')->insert($events);
    }
}
