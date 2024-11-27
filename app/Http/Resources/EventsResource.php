<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventsResource extends \Illuminate\Http\Resources\Json\ResourceCollection
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = $this->collection->map(function($item){
            return [
                'id' => $item->id,
                'status' => $item->status,
                'title' => $item->title,
                'description' => $item->description,
                'link' => $item->link,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
                'poster' => $item->getMedia('event_posters')->last()?->getFullUrl(),
            ];
        });
        return [
            'data' => $collection
        ];
    }
}
