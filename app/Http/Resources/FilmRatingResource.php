<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmRatingResource extends \Illuminate\Http\Resources\Json\ResourceCollection
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
                'video_id' => $item->video_id,
                'user_id' => $item->user_id,
                'stars' => $item->stars,
            ];
        });
        return [
            'data' => $collection
        ];
    }
}
