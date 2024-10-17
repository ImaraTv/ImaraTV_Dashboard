<?php

use App\{
    Http\Controllers\SocialiteController,
    Mail\UserRegistrationEmail,
    Models\User
};
use Illuminate\Support\Facades\{
    Mail,
    Route
};
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/vendor/livewire/livewire.js', $handle);
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(env('LIVEWIRE_UPDATE_URL'), $handle);
});
Route::get('/mail', function () {
    $user = User::whereId(5)->first();

    $mail = new UserRegistrationEmail('http://127.0.0.1:8000/verify', $user);
    Mail::to($user)->send($mail);
});


Route::get('/help', function() {
    if (Auth::user()->hasRole('creator')){
        return view('creator-manual');
    }
    if (Auth::user()->hasRole('sponsor')){
        return view('sponsor-manual');
    }
    else{
        return view('user-manual');
    }
});

// This route to handle Google login callback
//Route::post('/auth/google/login', [GoogleLoginController::class, 'handleGoogleLogin'])->name('google.login');

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');

Route::get('/create-film-project', \App\Filament\Pages\CreateFilmProject::class)->name('create-film-project');

Route::get('/file-uploader', \App\Filament\Pages\FileUploader::class)->name('file-uploader');
//Route::get('/file-uploader', [\App\Http\Controllers\UploadController::class, 'create'])->name('file-uploader');
Route::post('/upload-file', [\App\Http\Controllers\UploadController::class, 'uploadFile'])->name('ajax-file-upload');
Route::post('/save-file', [\App\Http\Controllers\UploadController::class, 'saveFile'])->name('save-uploaded-file');
