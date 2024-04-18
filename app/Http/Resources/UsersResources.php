<?php

namespace App\Http\Resources;

use Illuminate\Http\{
    Request,
    Resources\Json\ResourceCollection
};

class UsersResources extends ResourceCollection
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = $this->collection->map(function ($user) {
            return
            [
                'name' => $user->name,
                'email' => $user->email
            ];
        });
        return $collection->toArray();
    }
}
