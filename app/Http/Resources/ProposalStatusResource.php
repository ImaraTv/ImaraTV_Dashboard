<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalStatusResource extends \Illuminate\Http\Resources\Json\ResourceCollection
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
                'name' => $item->status,
                'id' => $item->id
            ];
        });
        return [
            'data' => $collection
        ];
    }
}
