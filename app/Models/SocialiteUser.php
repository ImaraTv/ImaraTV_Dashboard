<?php

namespace App\Models;

use DutchCodingCompany\FilamentSocialite\{
    Facades\FilamentSocialite,
    Models\Contracts\FilamentSocialiteUser as FilamentSocialiteUserContract
};
use Illuminate\{
    Contracts\Auth\Authenticatable,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo
};
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class SocialiteUser extends Model implements FilamentSocialiteUserContract
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
    ];


    /**
     * @return BelongsTo<\Illuminate\Database\Eloquent\Model&\Illuminate\Contracts\Auth\Authenticatable, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(FilamentSocialite::getUserModelClass());
    }

    public function getUser(): Authenticatable
    {
        return $this->user;
    }

    public static function findForProvider(string $provider, SocialiteUserContract $oauthUser): ?self
    {
        return self::query()
                        ->where('provider', $provider)
                        ->where('provider_id', $oauthUser->getId())
                        ->first();
    }

    public static function createForProvider(string $provider, SocialiteUserContract $oauthUser, Authenticatable $user): self
    {
        return self::query()
                        ->create([
                            'user_id' => $user->getKey(),
                            'provider' => $provider,
                            'provider_id' => $oauthUser->getId(),
        ]);
    }
}
