<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use HasFactory,
        SoftDeletes,
        InteractsWithMedia;

    const STATUS_DRAFT = 'DRAFT';
    const STATUS_PUBLISHED = 'PUBLISHED';
    const STATUS_UNPUBLISHED = 'UNPUBLISHED';

    protected $guarded = [];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_DRAFT => self::STATUS_DRAFT,
            self::STATUS_PUBLISHED => self::STATUS_PUBLISHED,
            self::STATUS_UNPUBLISHED => self::STATUS_UNPUBLISHED,
        ];
    }

    public function publishEvent()
    {
        $this->status = self::STATUS_PUBLISHED;
        $this->save();
        return $this;
    }

    public function unpublishEvent()
    {
        $this->status = self::STATUS_UNPUBLISHED;
        $this->save();
        return $this;
    }
}
