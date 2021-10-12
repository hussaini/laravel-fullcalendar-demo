<?php

namespace Tests\Browser;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EventTest extends DuskTestCase
{
    use RefreshDatabase;

    public Carbon $today_date;

    public function setUp(): void
    {
        parent::setUp();

        $this->today_date = now();
    }

    public function test_home_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->screenshot('home-page')
                ->assertSee($this->today_date->format('F Y'));
        });
    }

    public function test_add_event(): void
    {
        $input = [
            'title' => 'Test Event #1',
            'details' => 'This is test event details for testing',
        ];

        $this->browse(function (Browser $browser) use ($input) {
            $browser->visit('/')
                ->click('.fc-day-today')
                ->pause(500)
                ->type('#inputTitle', $input['title'])
                ->type('#textareaDetails', $input['details'])
                ->press('Save')
                ->pause(500)
                ->assertSee($input['title'])->assertSee($input['title'])
                ->refresh()
                ->assertSee($input['title'])
                ->click('.fc-day-today')
                ->pause(500)
                ->assertSee($input['title'])
                ->assertSee($input['details']);
        });
    }

    public function test_update_event(): void
    {
        $input = [
            'title' => 'Updated Test Event #1',
            'details' => 'This is updated test event details for testing',
        ];

        $this->browse(function (Browser $browser) use ($input) {
            $browser->visit('/')
                ->click('.fc-day-today')
                ->pause(500)
                ->type('#inputTitle', $input['title'])
                ->type('#textareaDetails', $input['details'])
                ->press('Save')
                ->pause(500)
                ->assertSee($input['title'])
                ->refresh()
                ->assertSee($input['title'])
                ->click('.fc-day-today')
                ->pause(500)
                ->assertSee($input['title'])
                ->assertSee($input['details']);
        });
    }

    public function test_delete_event(): void
    {
        $input = [
            'title' => 'Updated Test Event #1'
        ];

        $this->browse(function (Browser $browser) use ($input) {
            $browser->visit('/')
                ->assertSee($input['title'])
                ->click('.fc-day-today')
                ->pause(500)
                ->assertSee($input['title'])
                ->press('Delete')
                ->pause(500)
                ->assertDontSee($input['title'])
                ->refresh()
                ->assertDontSee($input['title'])
                ->click('.fc-day-today')
                ->assertDontSee($input['title']);
        });
    }
}
