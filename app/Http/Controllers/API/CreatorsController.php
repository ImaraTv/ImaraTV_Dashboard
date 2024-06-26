<?php

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Http\Resources\CreatorResource,
    Models\CreatorProfile
};
use Illuminate\Http\{
    JsonResponse,
    Request
};

class CreatorsController extends Controller
{

    public function creators(Request $request): CreatorResource
    {
        $creators = CreatorProfile::with(['user']);
        $creators = $creators->whereRelation('user', 'approved', 1);
        $creators = $creators->paginate(10);
        return new CreatorResource($creators);
    }

    public function creator(Request $request, $id): CreatorResource
    {
        $creator = CreatorProfile::with(['user'])->whereId($id)->whereRelation('user', 'approved', 1)->first();
        $resource = (new CreatorResource([$creator]));
        return $resource;

    }
}
