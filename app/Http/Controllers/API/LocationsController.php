<?php

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Http\Resources\LocationResource,
    Models\Location
};
use Illuminate\{
    Http\Request,
    Support\Carbon
};

class LocationsController extends Controller
{

    public function list(Request $request): LocationResource
    {
        $search = $request->has('search') ? $request->get('search') : '';

        $list = Location::select();

        if (!empty($search)) {
            $list = $list->where('location_name', '=', $search);
        }
        $list->orderBy('location_name', 'asc');
        $list = $list->get();

        return new LocationResource($list);
    }

}
