<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class VideosResource extends \Illuminate\Http\Resources\Json\ResourceCollection
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = $this->collection->map(function ($item) use ($request) {
            // name, duration,quality,category,description,image
//            $image = $this->getPoster($item->proposal);

            return
            [
                'id' => $item->id,
                'name' => $item->film_title,
                'slug' => $item->slug,
                'release_date' => $item->release_date,
                'duration' => $item->proposal->film_length,
                'category' => $item->proposal?->genre?->genre_name,
                'topics' => collect(explode(',', $item->proposal?->topics)),
                'description' => $item->synopsis,
                'vimeo_link' => $item->proposal->vimeo_link,
                'call_to_action_btn' => $item->call_to_action_text ?? $item->sponsor?->default_cta_text,
                'call_to_action_link' => $item->call_to_action_link ?? $item->sponsor?->default_cta_link,
                'creator' => [
                    'id' => $item->creator?->user_id,
                    'name' => $item->creator?->name,
                    'stage_name' => $item->creator?->stage_name,
                    'about' => $item->creator?->description,
                    'skills' => $item->creator?->skills_and_talents,
                ],
                'rating' => $item->proposal?->film_rating,
                'sponsor' => [
                    'name' => $item->sponsor?->organization_name,
                    'about' => $item->sponsor?->about_us,
                    'website' => $item->sponsor?->organization_website,
                    'logo' => $item->sponsor?->getMedia('logo')->first()?->getFullUrl(),
                ],
                'location' => [
                    'id' => $item->creator?->loc?->id,
                    'name' => $item->creator?->loc?->location_name,
                ],
                'stars' => ceil(collect($item->stars)->average('stars')),
                'image' => $item->proposal?->getMedia('posters')->last()?->getFullUrl(),
                'media' => [
                    'poster' => $item->proposal?->getMedia('posters')->last()?->getFullUrl(),
                    'trailer' => $item->proposal?->getMedia('trailers')->last()?->getFullUrl(),
                    'trailer_vimeo' => $item->proposal?->getMedia('trailers')->last()?->getCustomProperty('vimeo_link'),
                    'hd_film' => $item->proposal?->getMedia('videos')->last()?->getFullUrl(),
                    'hd_film_vimeo' => $item->proposal->vimeo_link,
                ]
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
            $model = collect($proposal->media)->filter(fn($i) => $i->collection_name === 'posters')->last();
            if ($model) {
                $file_path = storage_path() . '/app/public/' . $model->id . '/' . $model->file_name;
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
