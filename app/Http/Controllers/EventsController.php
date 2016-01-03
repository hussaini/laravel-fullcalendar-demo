<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Event;

use Input;

class EventsController extends Controller
{
    public function getEvents() {
        $events = Event::all();
        return json_encode($events);
    }

    public function getEvent() {
        $event = Event::find(Input::get('id'));
        return json_encode($event);
    }

    public function setEvent() {
        $result = ['success' => false];
        $input = Input::all();

        if(isset($input['id']) && !empty($input['id']) && Event::find($input['id'])) {
            $event = Event::find($input['id']);
            if($event) {
                $event->update($input);
                $result['event'] = $event;
                $result['success'] = true;
            }
        }
        else {
            $event = Event::create($input);
            $result['event'] = $event;
            $result['success'] = true;
        }

        return json_encode($result);
    }

    public function deleteEvent() {
        $result = ['success' => false];
        $id = Input::get('id');

        if(isset($id) && !empty($id) && Event::find($id)) {
            $event = Event::find($id);
            $event->delete();

            $result['success'] = true;
        }

        return json_encode($result);
    }
}
