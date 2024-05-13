<?php

use App\{
    Mail\UserRegistrationEmail,
    Models\User
};
use Illuminate\Support\Facades\{
    Mail,
    Route
};

Route::get('/', function () {
    return \redirect()->to('/login');
});
Route::get('/mail',function(){
    $user = User::whereId(5)->first();
    
    $mail = new UserRegistrationEmail('http://127.0.0.1:8000/verify',$user);
    Mail::to($user)->send($mail);
    
});

