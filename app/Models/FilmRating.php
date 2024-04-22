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
}
