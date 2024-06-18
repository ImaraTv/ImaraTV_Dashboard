<?php

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Http\Resources\FilmTopicResource,
    Models\FilmTopic
};
use Illuminate\{
    Http\Request,
    Support\Carbon
};

class FilmTopicsController extends Controller
{

    public function list(Request $request): FilmTopicResource
    {
        $search = $request->has('search') ? $request->get('search') : '';

        $list = FilmTopic::select();

        if (!empty($search)) {
            $list = $list->where('topic_name', '=', $search);
        }
        $list->orderBy('topic_name', 'asc');
        $list = $list->get();

        return new FilmTopicResource($list);
    }

}
