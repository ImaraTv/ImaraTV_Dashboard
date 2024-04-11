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
        $categories = FilmGenre::paginate(1000);
        return new CategoriesResource($categories);
    }
}
