<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UpcomingVideosResource extends VideosResource
{
    public function getDatesOfMonth($format = 'Y-m-d H:i:s') {
        $month = date('m');
        $year = date('Y');
        //$totalDays = date("t");
        $totalDays = 30;
        $start = $year . '-' . $month . '-01 12:00:00';
        $end = $year . '-' . $month . '-' . $totalDays . ' 12:00:00';

        $array = [];
        $interval = new \DateInterval('P1D');
        $dateEnd = new \DateTime($end);
        $dateEnd->add($interval);
        $period = new \DatePeriod(new \DateTime($start), $interval, $dateEnd);

        foreach($period as $date) {
            $array[] = $date->format($format);
        }
        return $array;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $days = 30;
        $calendarDays = $this->getDatesOfMonth();
        $collection = $this->collection;
        $collection->each(function($item, $key) use($calendarDays, $days) {
            if ($key <= array_key_last($calendarDays)) {
                $assigned_date = $calendarDays[$key];
            }
            else {
                $newKey = ($key % $days);
                $assigned_date = $calendarDays[$newKey];
            }

            $item->release_date = $assigned_date;
            return $item;
        });

        $collection = $collection->map(function ($item) use ($request) {
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

}
