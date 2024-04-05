<?php

namespace App\Providers;

use DutchCodingCompany\FilamentSocialite\{
    Facades\FilamentSocialite as FilamentSocialiteFacade,
    FilamentSocialite
};
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        FilamentSocialiteFacade::setCreateUserCallback(fn(string $provider, SocialiteUserContract $oauthUser, FilamentSocialite $socialite) => $socialite->getUserModelClass()::create([
                    'name' => $oauthUser->getName(),
                    'email' => $oauthUser->getEmail(),
        ]));

        FilamentSocialiteFacade::setUserResolver(fn(string $provider, SocialiteUserContract $oauthUser, FilamentSocialite $socialite) => dd([$socialite,$oauthUser]));
    }
}
