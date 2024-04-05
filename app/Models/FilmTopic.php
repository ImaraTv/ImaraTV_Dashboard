<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class FilmTopic extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $table = "film_topics";

    protected $guarded = [];
}
