<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};
use Spatie\MediaLibrary\{
    HasMedia,
    InteractsWithMedia
};

class CreatorProposal extends Model implements HasMedia
{

    use HasFactory,
        SoftDeletes,
        InteractsWithMedia;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function creator()
    {
        return $this->belongsTo(CreatorProfile::class, 'user_id', 'user_id');
    }
    public function genre()
    {
        return $this->belongsTo(FilmGenre::class, 'film_genre', 'id');
    }

    public function sponsor()
    {
        return $this->belongsTo(SponsorProfile::class, 'sponsored_by', 'user_id');
    }

    public function proposal_status()
    {
        return $this->belongsTo(ProposalStatus::class, 'status', 'id');
    }
}
