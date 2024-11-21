<?php

namespace App\Services;

use App\Filament\Resources\UserResource;
use App\Mail\CreatorSponsorRegisteredEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AdminService
{
    public static function notifyAdminsofNewRegistration(User $user) {
        $admins = User::admins()->approved()->get();
        foreach ( $admins as $admin) {
            $profile_link = UserResource\Pages\ViewUser::getUrl([$user]); // TODO: replace this with link to profile page
            if ($admin->canReceiveAdminEmails()) {
                Mail::to($admin)->send(new CreatorSponsorRegisteredEmail($profile_link, $admin, $user, ucfirst($user->role)));
            }
        }
    }
}
