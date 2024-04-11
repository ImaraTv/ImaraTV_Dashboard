<?php

use App\Http\Controllers\API\{
    AuthController,
    CategoriesController,
    CreatorsController,
    VideosController
};
use Illuminate\Support\Facades\Route;
use function Safe\date;

/**
 * Description of api
 *
 * @author Ansel Melly <ansel@anselmelly.com> @anselmelly
 * @date Apr 1, 2024
 * @link https://anselmelly.com
 */
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
        ], function ($router) {

            Route::post('login', [AuthController::class, 'login']);
            Route::post('register', [AuthController::class, 'register']);
        });
Route::group([], function () {
    Route::get('/creators', [CreatorsController::class, 'creators']);
    Route::get('/videos', [VideosController::class, 'videos']);
    Route::get('/videos/{id}', [VideosController::class, 'video']);
    Route::get('/categories', [CategoriesController::class, 'categories']);
});
