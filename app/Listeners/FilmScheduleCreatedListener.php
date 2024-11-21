<?php

namespace App\Listeners;

use App\Events\FilmScheduleCreatedEvent;
use App\Services\NewsletterService;

class FilmScheduleCreatedListener
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FilmScheduleCreatedEvent $event): void
    {
        $film_schedule = $event->getPublishingSchedule();
        //TODO: send email to Sponsor and Creator

    }
}
