<?php

namespace App\Listeners;

use App\Models\User;
use App\Services\AdminService;
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
        /* @var $user User */
        $user = $event->getUser();

        if ($user->newsletter_consent) {
            NewsletterService::sendWelcomeEmail($user->email);
        }

        if ($user->hasRole(['creator', 'sponsor'])) {
            // send email to admin when new sponsor or creator is registered
            AdminService::notifyAdminsofNewRegistration($user);

            // create profile record
            $user->createUserProfile();
        }

    }
}
