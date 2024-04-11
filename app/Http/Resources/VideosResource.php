<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideosResource extends \Illuminate\Http\Resources\Json\ResourceCollection
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = $this->collection->map(function ($item) {
            // name, duration,quality,category,description,image



            $image = $this->getPoster($item->proposal);

            return
            [
                'id' => $item->id,
                'name' => $item->film_title,
                'duration' => $item->proposal->film_length,
                'category' => $item->proposal?->genre?->genre_name,
                'description' => $item->synopsis,
                'vimeo_link' => $item->proposal->vimeo_link,
                'call_to_action' => $item->call_to_action_text,
                'call_to_action_link' => $item->call_to_action_link,
                'image' => $image,
            ];
        });
        return [
            'data' => $collection
        ];
    }

    protected function getPoster($proposal)
    {
        $image = '';

        $has_mage = collect($proposal->media)->filter(fn($i) => $i->collection_name === 'posters')->count();

        if ($has_mage > 0) {
            $image = collect($proposal->media)->filter(fn($i) => $i->collection_name === 'posters')->last();
            if ($image) {
                $file_path = storage_path() . '/app/public/' . $image->id . '/' . $image->file_name;
                if (file_exists($file_path)) {
                    $image = $this->imageToBase64($file_path);
                }
            }
        }
        return $image;
    }

    protected function imageToBase64($img_file)
    {

        $imgData = base64_encode(file_get_contents($img_file));

        $src = 'data: ' . mime_content_type($img_file) . ';base64,' . $imgData;
        return $src;
    }
}
