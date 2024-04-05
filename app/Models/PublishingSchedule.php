<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class PublishingSchedule extends Model implements FilamentUser
{

    use HasFactory,
        SoftDeletes,
            HasPanelShield;

    protected $guarded = [];

    protected $table = "publishing_schedules";


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
    public function proposal(){
        return $this->belongsTo(CreatorProposal::class, 'proposal_id', 'id');
    }
}
