<?php

namespace App\Http\Resources;

use Illuminate\Http\{
    Request,
    Resources\Json\ResourceCollection
};

class CreatorResource extends ResourceCollection
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $collection = $this->collection->map(function ($item) {

            if (is_null($item)) {
                return [];
            }

            $image = '';
            $has_mage = collect($item->media)->filter(fn($i) => $i->collection_name === 'profile_pictures')->count();

            if ($has_mage > 0) {
                $image = collect($item->media)->last();
                if ($image) {
                    $file_path = storage_path() . '/app/public/' . $image->id . '/' . $image->file_name;
                    if (file_exists($file_path)) {
                        $image = $this->imageToBase64($file_path);
                    }
                }
            }

            return [
        'id' => $item->id,
        'name' => $item->name,
        'stage_name' => $item->stage_name,
        'user_id' => $item->user_id,
        'about' => $item->description,
        'skills_and_talents' => $item->skills_and_talents,
        'image' => $image,
            ];
        });

        if ($collection->count() == 1) {
            return collect($collection->first())->toArray();
        }

        return $collection->toArray();
    }

    protected function imageToBase64($img_file)
    {

        $imgData = base64_encode(file_get_contents($img_file));

        $src = 'data: ' . mime_content_type($img_file) . ';base64,' . $imgData;
        return $src;
    }
}
