<?php

namespace App\Models;

use App\Exports\FilmSchedules;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class VideoBookmark extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $guarded = [];


    public function videos()
    {
        return $this->belongsTo(PublishingSchedule::class, 'video_id');
    }
}
