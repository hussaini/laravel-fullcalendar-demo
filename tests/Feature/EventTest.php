<?php

namespace Tests\Feature;

use App\Models\Event;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        Carbon::setTestNow('2020-01-01');
    }

    public function test_get_all_events()
    {
        $response = $this->get(route('events.index'));

        $response->assertOk();
        $response->assertJsonCount(4);
    }

    public function test_get_events_with_start_date()
    {
        $response = $this->get(route('events.index', ['startAt' => '2020-01-20T00:00:00+08:00']));

        $response->assertOk();
        $response->assertJsonCount(2);
    }

    public function test_get_events_with_end_date()
    {
        $response = $this->get(route('events.index', ['endAt' => '2020-01-15T23:59:59+08:00']));

        $response->assertOk();
        $response->assertJsonCount(2);
    }

    public function test_get_events_with_start_and_end_date()
    {
        $response = $this->get(route('events.index', ['startAt' => '2020-01-15T00:00:00+08:00', 'endAt' => '2020-01-31T23:59:59+08:00']));

        $response->assertOk();
        $response->assertJsonCount(3);
    }

    public function test_get_events_with_empty_result()
    {
        $response = $this->get(route('events.index', ['startAt' => '2019-01-01T00:00:00+08:00', 'endAt' => '2019-01-31T23:59:59+08:00']));

        $response->assertOk();
        $response->assertJsonCount(0);
    }

    public function test_get_event()
    {
        $response = $this->get(route('events.show', ['event' => 1]));

        $response->assertOk();
        $response->assertJsonFragment([
            'id' => 1,
        ]);
    }

    public function test_get_event_not_found()
    {
        $response = $this->get(route('events.show', ['event' => 9999]));

        $response->assertNotFound();
    }

    public function test_store_event()
    {
        $response = $this->postJson(route('events.store'), [
            'title' => 'Test storing event',
            'details' => 'Details of storing event',
            'startAt' => '2021-01-05',
            'endAt' => '2021-01-05',
        ]);

        $data = json_decode($response->content(), 1);

        $response->assertCreated();
        $this->assertDatabaseHas(Event::class, [
            'id' => $data['id'],
            'title' => $data['title'],
            'details' => $data['details'],
            'start_at' => (new Carbon($data['startAt']))->timestamp,
            'end_at' => (new Carbon($data['endAt']))->timestamp,
        ]);
    }

    public function test_store_event_with_start_date()
    {
        $response = $this->postJson(route('events.store'), [
            'title' => 'Test storing event',
            'details' => 'Details of storing event',
            'startAt' => '2021-01-05',
        ]);

        $data = json_decode($response->content(), 1);

        $response->assertCreated();
        $this->assertDatabaseHas(Event::class, [
            'id' => $data['id'],
            'title' => $data['title'],
            'details' => $data['details'],
            'start_at' => (new Carbon($data['startAt']))->timestamp,
            'end_at' => null,
        ]);
    }

    public function test_store_event_with_invalid_input()
    {
        $response = $this->postJson(route('events.store'), [
            'startAt' => '2021-01-05',
        ]);

        $response->assertStatus(422);
    }

    public function test_update_event()
    {
        $input = [
            'title' => 'Updated title',
            'details' => null,
            'startAt' => (new Carbon('2021-01-05'))->toIso8601String(),
            'endAt' => (new Carbon('2021-01-05'))->toIso8601String(),
        ];

        $response = $this->patchJson(route('events.update', ['event' => 1]), $input);

        $response->assertOk();
        $response->assertJsonFragment($input);
    }

    public function test_update_event_not_exists()
    {
        $input = [
            'title' => 'Updated title',
            'details' => null,
            'startAt' => (new Carbon('2021-01-05'))->toIso8601String(),
            'endAt' => (new Carbon('2021-01-05'))->toIso8601String(),
        ];

        $response = $this->patchJson(route('events.update', ['event' => 100000]), $input);

        $response->assertNotFound();
    }

    public function test_delete_event()
    {
        $response = $this->delete(route('events.destroy', ['event' => 1]));

        $response->assertNoContent();
        $this->assertDatabaseMissing(Event::class, [
            'id' => 1
        ]);
    }

    public function test_delete_event_not_exists()
    {
        $response = $this->delete(route('events.destroy', ['event' => 99999]));

        $response->assertNotFound();
    }
}