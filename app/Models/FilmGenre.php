<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class FilmGenre extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $table = "film_genres";

    protected $guarded = [];
}
