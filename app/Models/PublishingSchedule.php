<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class PublishingSchedule extends Model
{
    use Sluggable;
    use HasFactory,
        SoftDeletes;

    protected $table = "publishing_schedules";

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'film_title',
        'slug',
    ];

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

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'film_title'
            ]
        ];
    }
}
