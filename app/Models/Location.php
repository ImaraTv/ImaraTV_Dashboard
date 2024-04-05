<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class Location extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $guarded = [];

    protected $table = "locations";
}
