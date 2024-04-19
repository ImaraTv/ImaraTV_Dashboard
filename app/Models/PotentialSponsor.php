<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class PotentialSponsor extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $table = "potential_sponsors";

    protected $guarded = [];
    
    public function sponsor()
    {
         return $this->belongsTo(SponsorProfile::class, 'sponsor_id', 'user_id');
    }
}
