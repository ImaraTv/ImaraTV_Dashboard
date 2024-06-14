<?php

use App\{
    Mail\UserRegistrationEmail,
    Models\User
};
use Illuminate\Support\Facades\{
    Mail,
    Route
};
use Livewire\Livewire;

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


