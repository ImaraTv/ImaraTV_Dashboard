<?php

namespace App\Events;

use App\Models\PublishingSchedule;
use Illuminate\Queue\SerializesModels;

class FilmScheduleCreatedEvent
{
    use SerializesModels;

    public PublishingSchedule $film_schedule;

    public function __construct(PublishingSchedule $film_schedule)
    {
        $this->$film_schedule = $film_schedule;
    }

    public function getPublishingSchedule(): PublishingSchedule
    {
        return $this->film_schedule;
    }
}
