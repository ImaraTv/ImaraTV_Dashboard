<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model
};

class County extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "geo_counties";
}
