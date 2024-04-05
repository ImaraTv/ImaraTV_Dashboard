<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};

class ProposalStatus extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $table = "proposal_statuses";

    protected $guarded = [];
}
