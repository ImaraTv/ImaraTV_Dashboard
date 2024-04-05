<?php

namespace App\Models;

use DutchCodingCompany\FilamentSocialite\Models\Contracts\FilamentSocialiteUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class SocialiteUser implements FilamentSocialiteUser
{

    public function getUser(): Authenticatable
    {
        //
    }

    public static function findForProvider(string $provider, SocialiteUserContract $oauthUser): ?self
    {
        //
    }

    public static function createForProvider(
            string $provider,
            SocialiteUserContract $oauthUser,
            Authenticatable $user
    ): self
    {
        //
    }
}
