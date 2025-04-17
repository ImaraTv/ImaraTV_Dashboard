<?php

namespace App\Http\Controllers\API;

use App\{Http\Controllers\Controller,
    Http\Resources\UpcomingVideosResource,
    Http\Resources\VideosResource,
    Models\PublishingSchedule};
use Illuminate\{
    Database\Eloquent\Builder,
    Http\Request,
    Support\Carbon
};

class VideosController extends Controller
{
    protected function videosFilter(Request $request, bool $show_upcoming = false): Builder
    {
        $search = $request->has('search') ? $request->get('search') : '';
        $filter = $request->has('filter') ? $request->get('filter') : '';
        $category = $request->has('category') ? $request->get('category') : '';
        $genre = $request->has('genre') ? $request->get('genre') : '';
        $rating = $request->has('rating') ? $request->get('rating') : '';
        $sponsor_id = $request->has('sponsor_id') ? $request->get('sponsor_id') : '';
        $creator_id = $request->has('creator_id') ? $request->get('creator_id') : '';
        $location_id = $request->has('location_id') ? $request->get('location_id') : '';
        $topic = $request->has('topic') ? $request->get('topic') : '';

        $videos = PublishingSchedule::with(['proposal', 'creator', 'sponsor', 'proposal.genre','stars']);
        if ($show_upcoming) {
            $videos = $videos->whereDate('release_date', '>', Carbon::now()->toDateString());
        } else {
            $videos = $videos->whereDate('release_date', '<=', Carbon::now()->toDateString());
        }


        // fetch videos where vimeo_link is not null
        $videos = $videos->whereHas('proposal', function ($q) {
            $q->whereNotNull('vimeo_link')->where('vimeo_link', '<>', '');
        });

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

        // replaced category with genre
        if ($category != '') {
            $videos = $videos->whereHas('proposal.genre', function ($q) use ($category) {
                $q->where('genre_name', '=', $category);
            });
        }
        if ($genre != '') {
            $videos = $videos->whereHas('proposal.genre', function ($q) use ($genre) {
                $q->where('genre_name', '=', $genre);
            });
        }
        if ($topic != '') {
            $videos = $videos->whereHas('proposal', function ($q) use ($topic) {
                $q->where('topics', 'LIKE', '%' . $topic . '%');
            });
        }
        if ($rating != '') {
            $videos = $videos->whereHas('proposal', function ($q) use ($rating) {
                $q->where('film_rating', $rating);
            });
        }
        if (!empty($sponsor_id)) {
            $videos = $videos->where('sponsor_id', $sponsor_id);
        }
        if (!empty($creator_id)) {
            $videos = $videos->where('creator_id', $creator_id);
        }
        if (!empty($location_id)) {
            $videos = $videos->whereHas('creator', function ($q) use ($location_id) {
                $q->where('location', $location_id);
            });
        }

        return $videos;
    }
    public function videos(Request $request): VideosResource
    {
        $videos = $this->videosFilter($request);
        $limit = $request->has('limit') ? $request->get('limit', 20) : 20;
        $videos = $videos->paginate($limit);

        return new VideosResource($videos);
    }

    public function video(Request $request, $id)
    {
        $videos = PublishingSchedule::with(['proposal', 'creator', 'sponsor', 'proposal.genre'])
                        ->whereId($id)->get();

        return new VideosResource($videos);
    }

    public function getVideoBySlug(Request $request, $slug)
    {
        $videos = PublishingSchedule::with(['proposal', 'creator', 'sponsor', 'proposal.genre']);
        $videos = $videos->where('slug', $slug)->get();

        return new VideosResource($videos);
    }

    public function latest(Request $request)
    {
        $videos = $this->videosFilter($request);
        $videos = $videos->orderBy('release_date', 'desc');
        $limit = $request->has('limit') ? $request->get('limit', 20) : 10;

        $videos = $videos->paginate($limit);
        return new VideosResource($videos);
    }

    public function recommended(Request $request)
    {
        $videos = $this->videosFilter($request);
        $limit = $request->has('limit') ? $request->get('limit', 20) : 20;
        $videos = $videos->inRandomOrder();
        $videos = $videos->paginate($limit);

        return new VideosResource($videos);
    }

    public function trending(Request $request)
    {
        $videos = $this->videosFilter($request);
        //TODO: implement ordering by most views
        $videos = $videos->withAvg('stars', 'stars');
        $videos = $videos->orderBy('stars_avg_stars', 'desc');
        $limit = $request->has('limit') ? $request->get('limit', 20) : 10;

        $videos = $videos->paginate($limit);
        return new VideosResource($videos);
    }

    public function featured(Request $request)
    {
        $videos = $this->videosFilter($request);
        $videos = $videos->where('is_featured', 1);
        $videos = $videos->orderBy('featured_at', 'desc');
        $limit = $request->has('limit') ? $request->get('limit', 6) : 6;

        $videos = $videos->paginate($limit);
        return new VideosResource($videos);
    }

    public function upcoming(Request $request)
    {
        //$videos = $this->videosFilter($request, true);
        //$limit = $request->has('limit') ? $request->get('limit', 20) : 20;
        //$videos = $videos->orderBy('release_date', 'asc');
        //$videos = $videos->paginate($limit);

        ## spread films on the current month calendar
        $videos = $this->videosFilter($request, false);
        $videos = $videos->orderBy('release_date', 'asc');
        $videos = $videos->paginate(1000);

        return new UpcomingVideosResource($videos);
    }
}
