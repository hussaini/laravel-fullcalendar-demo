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
        $events = Event::query();

        if ($start = request('start', null)) {
            $events->where('start_at', '>=', (new Carbon($start))->timestamp);
        }

        if ($end = request('end', null)) {
            $events->where('start_at', '<=', (new Carbon($end))->timestamp);
        }

        return new EventCollection($events->get());
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
