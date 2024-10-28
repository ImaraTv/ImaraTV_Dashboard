<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model
};

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "geo_countries";
}
