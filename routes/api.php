<?php

use App\Http\Controllers\API\{
    AuthController,
    CreatorsController
};
use Illuminate\Support\Facades\Route;

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
});
