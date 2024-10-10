<?php

namespace App\Models;

use App\Mail\SponsorExpressionOfInterestEmail;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};
use Illuminate\Support\Facades\Mail;

class PotentialSponsor extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $table = "potential_sponsors";

    protected $guarded = [];

    public function sponsor()
    {
         return $this->belongsTo(User::class, 'sponsor_id', 'id');
    }

    public function proposal()
    {
        return $this->belongsTo(CreatorProposal::class, 'proposal_id', 'id');
    }

    public static function saveEOI($create_data, $update_data) {
        $saved = PotentialSponsor::updateOrCreate($create_data, $update_data);
        $model = static::with(['sponsor', 'proposal'])->find($saved->id);

        if ($model) {
            $mailToSponsor = new SponsorExpressionOfInterestEmail($model->proposal, $model->sponsor, false);
            $mailToAdmin = new SponsorExpressionOfInterestEmail($model->proposal, $model->sponsor, true);

            Mail::to([$model->sponsor->email])->send($mailToSponsor);
            Mail::to([env('APP_CONTACT_EMAIL')])->send($mailToAdmin);
        }

        return $model;
    }
}
