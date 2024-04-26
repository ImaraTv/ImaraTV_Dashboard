<?php

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Http\Resources\VideosResource,
    Models\PublishingSchedule
};
use Illuminate\{
    Http\Request,
    Support\Carbon
};

class VideosController extends Controller
{

    public function videos(Request $request): VideosResource
    {
        $search = $request->has('search') ? $request->get('search') : '';
        $filter = $request->has('filter') ? $request->get('filter') : '';
        $category = $request->has('category') ? $request->get('category') : '';
        $rating = $request->has('rating') ? $request->get('rating') : '';

        $videos = PublishingSchedule::with(['proposal', 'creator', 'sponsor', 'proposal.genre'])
                ->where('release_date', "<=", Carbon::now());
        if ($search != '') {
            $videos = $videos->where(function ($q) use ($search) {
                $q->where('film_title', 'like', '%' . $search . '%')
                        ->orWhere('synopsis', 'like', '%' . $search . '%');
                $exS = explode(' ', $search);
                if (count($exS) > 0) {
                    foreach ($exS as $S) {
                        if (strlen($S) > 2) {
                            $q->orWhere('synopsis', 'like', '%' . $S . '%')
                                    ->orWhere('film_title', 'like', '%' . $S . '%');
                        }
                    }
                }
            });
        }

        if ($category != '') {
            $videos = $videos->whereHas('proposal.genre', function ($q) use ($category) {
                $q->where('genre_name', '=', $category);
            });
        }
        if ($rating != '') {
            $videos = $videos->whereHas('proposal', function ($q) use ($rating) {
                $q->where('film_rating', $rating);
            });
        }

        $videos = $videos
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
