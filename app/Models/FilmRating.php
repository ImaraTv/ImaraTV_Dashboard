<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class FilmRating extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function film()
    {
        return $this->belongsTo(PublishingSchedule::class, 'video_id', 'id');
    }
}
