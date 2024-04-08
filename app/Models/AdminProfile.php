<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};
use Spatie\MediaLibrary\{
    HasMedia,
    InteractsWithMedia
};

class AdminProfile extends Model implements HasMedia
{

    use HasFactory,
        SoftDeletes,
        InteractsWithMedia;

    protected $table = 'admin_profiles';

    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
