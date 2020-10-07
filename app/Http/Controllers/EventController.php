<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventCollection;
use App\Models\Event;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    public function index()
    {
        $start_at = new Carbon(request()->query('start'));
        $end_at = new Carbon(request()->query('end'));

        $events = Event::where('start_at', '>=', $start_at->timestamp)
            ->where('start_at', '<=', $end_at->timestamp)
            ->get();

        return new EventCollection($events);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function store()
    {
        Event::create(request()->all());

        return response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Event $event)
    {
        $event->update(request()->all());

        return response()->noContent();
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->noContent();
    }
}
