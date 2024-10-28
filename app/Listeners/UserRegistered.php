<?php

namespace App\Listeners;

use Filament\Events\Auth\Registered;
use App\Services\NewsletterService;

class UserRegistered
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
    public function handle(Registered $event): void
    {
        $user = $event->getUser();

        if ($user->newsletter_consent) {
            NewsletterService::sendWelcomeEmail($user->email);
        }

    }
}
