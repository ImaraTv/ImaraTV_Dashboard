<?php

namespace App\Http\Resources;

use App\Models\PublishingSchedule;
use Illuminate\Http\{
    Request,
    Resources\Json\ResourceCollection
};

class VideoBookmarks extends ResourceCollection
{

    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = $this->collection->map(function ($item) {
            $video = PublishingSchedule::with(['sponsor','creator','proposal','genre'])->first();
            return
            [
                'id' => $item->id,
                'videos' => (new \App\Http\Resources\VideosResource([$video]))
            ];
        });
        return $collection
                
                ->toArray();
    }
}
