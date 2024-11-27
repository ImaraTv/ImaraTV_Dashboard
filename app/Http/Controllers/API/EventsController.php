<?php

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Http\Resources\EventsResource,
    Models\Event};
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function events(Request $request): EventsResource
    {
        $search = $request->has('search') ? $request->get('search') : '';

        $events = Event::where('status', Event::STATUS_PUBLISHED)->withoutTrashed();
        if ($search != '') {
            $events = $events->where('title', 'like', '%' . $search . '%');
        }
        $events = $events->paginate(100);
        return new EventsResource($events);
    }
}
