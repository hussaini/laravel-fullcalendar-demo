<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventFormRequest;
use App\Http\Resources\EventCollection;
use App\Http\Resources\Event as EventResource;
use App\Models\Event;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::query();

        if ($startAt = request('startAt')) {
            $events->where('start_at', '>=', (new Carbon($startAt))->timestamp);
        }

        if ($endAt = request('endAt')) {
            $events->where('start_at', '<=', (new Carbon($endAt))->timestamp);
        }

        return new EventCollection($events->get());
    }

    public function show(Event $event)
    {
        return response($event);
    }

    public function store(EventFormRequest $request)
    {
        return EventResource::make(Event::create($request->validated()))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(EventFormRequest $request, Event $event)
    {
        $event->update($request->validated());
        return EventResource::make($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->noContent();
    }
}
