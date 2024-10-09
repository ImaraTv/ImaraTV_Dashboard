<?php

use App\Http\Controllers\API\{AuthController,
    CategoriesController,
    CreatorsController,
    FilmGenreController,
    FilmTopicsController,
    LocationsController,
    ProposalStatusController,
    SiteController,
    UsersController,
    VideosController};
use Illuminate\Support\Facades\Route;
use function Safe\date;

/**
 * Description of api
 *
 * @author Ansel Melly <ansel@anselmelly.com> @anselmelly
 * @date Apr 1, 2024
 * @link https://anselmelly.com
 */
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('get-user-by-email', [AuthController::class, 'getUserByEmail']);
    Route::post('verify', [AuthController::class, 'verifyEmail']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});
Route::group(['middleware' => 'api'], function () {

    Route::get('/videos', [VideosController::class, 'videos']);
    Route::get('/videos/latest', [VideosController::class, 'latest']);
    Route::get('/videos/recommended', [VideosController::class, 'recommended']);
    Route::get('/videos/trending', [VideosController::class, 'trending']);
    Route::get('/videos/featured', [VideosController::class, 'featured']);
    Route::get('/videos/upcoming', [VideosController::class, 'upcoming']);
    Route::get('/videos/{id}', [VideosController::class, 'video']);
    Route::get('/videos/slug/{slug}', [VideosController::class, 'getVideoBySlug']);
    Route::get('/creators', [CreatorsController::class, 'creators']);
    Route::get('/creators/{id}', [CreatorsController::class, 'creator']);
    Route::get('/categories', [CategoriesController::class, 'categories']);
    Route::get('/topics', [FilmTopicsController::class, 'list']);
    Route::get('/genres', [FilmGenreController::class, 'list']);
    Route::get('/proposal-status', [ProposalStatusController::class, 'list']);
    Route::get('/locations', [LocationsController::class, 'list']);
    Route::post('/contact', [SiteController::class, 'contact']);

    Route::prefix('newsletter')->group(function () {
        Route::post('/subscribe', [SiteController::class, 'newsletterSubscribe']);
        Route::post('/unsubscribe', [SiteController::class, 'newsletterUnsubscribe']);
    });

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::get('/bookmarks', [UsersController::class, 'videoBookmarks']);
        Route::post('/bookmark', [UsersController::class, 'bookmarkVideo']);
        Route::post('/rate', [UsersController::class, 'rateVideo']);
    });
});
