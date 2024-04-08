<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};
use Spatie\MediaLibrary\{
    HasMedia,
    InteractsWithMedia
};

class SponsorProfile extends Model implements HasMedia
{

    use HasFactory,
        SoftDeletes,
        InteractsWithMedia;

    protected $casts = [
        'topics_of_interest' => 'array',
        'locations_of_interest' => 'array',
    ];

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
