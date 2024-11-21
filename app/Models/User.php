<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Filament\{
    Models\Contracts\FilamentUser,
    Panel
};
use Illuminate\{Contracts\Auth\MustVerifyEmail,
    Database\Eloquent\Builder,
    Database\Eloquent\Factories\HasFactory,
    Foundation\Auth\User as Authenticatable,
    Notifications\Notifiable};
use Spatie\{
    MediaLibrary\HasMedia,
    MediaLibrary\InteractsWithMedia,
    Permission\Traits\HasRoles
};
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail, HasMedia, JWTSubject
{

    use HasFactory,
        Notifiable,
        HasRoles,
        HasPanelShield,
        InteractsWithMedia, AuthenticationLoggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'approved',
        'google_id',
        'email_verified_at',
        'newsletter_consent',
        'receive_admin_emails'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function booted()
    {
        static::created(function ($model) {
            $model->assignRole($model->role);
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }

    public function scopeAdmins(Builder $query): void
    {
        $this->scopeRole($query, ['super_admin']);
    }
    public function scopeApproved(Builder $query): void
    {
        $query->where('approved', 1);
    }

    public function canReceiveAdminEmails(): bool
    {
        return $this->hasRole(['admin', 'super_admin']) && $this->receive_admin_emails;
    }


}
