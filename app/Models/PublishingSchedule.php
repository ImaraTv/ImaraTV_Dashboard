<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class PublishingSchedule extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $guarded = [];

    protected $table = "publishing_schedules";


    public function sponsor()
    {
        return $this->belongsTo(\App\Models\SponsorProfile::class, 'sponsor_id', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\CreatorProfile::class, 'creator_id', 'user_id');
    }

    public function genre()
    {
        return $this->belongsTo(FilmGenre::class, 'film_type', 'id');
    }

    public function proposal()
    {
        return $this->belongsTo(\App\Models\CreatorProposal::class, 'proposal_id', 'id');
    }

    public function stars()
    {
        return $this->hasMany(FilmRating::class, 'video_id', 'id');
    }
}
