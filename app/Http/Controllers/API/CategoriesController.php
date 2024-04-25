<?php

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Http\Resources\CategoriesResource,
    Models\FilmGenre
};
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function categories(Request $request): CategoriesResource
    {
        $filter = $request->has('filter') ? $request->get('filter') : '';

        $categories = (new FilmGenre());
        if ($filter != '') {
            $categories = $categories->where('genre_name', '=', $filter);
        }
        $categories = $categories->paginate(1000);
        return new CategoriesResource($categories);
    }
}
