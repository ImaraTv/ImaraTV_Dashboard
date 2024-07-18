<?php

namespace App\Http\Controllers\API;

use App\{Http\Controllers\Controller, Http\Resources\FilmGenreResource, Models\FilmGenre};
use Illuminate\{
    Http\Request,
    Support\Carbon
};

class FilmGenreController extends Controller
{

    public function list(Request $request): FilmGenreResource
    {
        $search = $request->has('search') ? $request->get('search') : '';

        $list = FilmGenre::select();

        if (!empty($search)) {
            $list = $list->where('genre_name', '=', $search);
        }
        $list->orderBy('genre_name', 'asc');
        $list = $list->get();

        return new FilmGenreResource($list);
    }

}
