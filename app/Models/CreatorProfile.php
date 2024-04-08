<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};
use Spatie\MediaLibrary\{
    HasMedia,
    InteractsWithMedia
};

class CreatorProfile extends Model implements HasMedia, FilamentUser
{

    use HasFactory,
        SoftDeletes,
        InteractsWithMedia,
        HasPanelShield;

    protected $casts = [
        'skills_and_talents' => 'array',
    ];

    protected $table = "creator_profiles";

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location');
    }
}
