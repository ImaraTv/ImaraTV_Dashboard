<?php

namespace App\Providers;

use App\{
    Models\Location,
    Policies\LocationPolicy
};
use Illuminate\{
    Foundation\Support\Providers\AuthServiceProvider,
    Support\Facades\Gate
};

class FAuthServiceProvider extends AuthServiceProvider
{

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
