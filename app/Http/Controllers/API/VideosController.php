<?php

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Http\Resources\VideosResource,
    Models\PublishingSchedule
};
use Illuminate\Http\Request;

class VideosController extends Controller
{

    public function videos(Request $request): VideosResource
    {
        $videos = PublishingSchedule::with(['proposal', 'creator', 'sponsor', 'proposal.genre'])
                ->where('release_date',"<=", \Illuminate\Support\Carbon::now())
                ->paginate(10);

        return new VideosResource($videos);
    }

    public function video(Request $request, $id)
    {
        $videos = PublishingSchedule::with(['proposal', 'creator', 'sponsor', 'proposal.genre'])
                ->whereId($id)->get();
        
        return new VideosResource($videos);
    }
}
