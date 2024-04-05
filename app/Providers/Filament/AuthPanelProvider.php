<?php

namespace App\Providers\Filament;

use Filament\{
    Http\Middleware\DisableBladeIconComponents,
    Http\Middleware\DispatchServingFilamentEvent,
    Panel,
    PanelProvider
};
use Illuminate\{
    Cookie\Middleware\AddQueuedCookiesToResponse,
    Cookie\Middleware\EncryptCookies,
    Foundation\Http\Middleware\VerifyCsrfToken,
    Routing\Middleware\SubstituteBindings,
    Session\Middleware\AuthenticateSession,
    Session\Middleware\StartSession,
    View\Middleware\ShareErrorsFromSession
};

class AuthPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel->id('auth')
                        ->path('auth')
                        ->login()
                        ->registration()
                        ->passwordReset()
                ->middleware([
                            EncryptCookies::class,
                            AddQueuedCookiesToResponse::class,
                            StartSession::class,
                            AuthenticateSession::class,
                            ShareErrorsFromSession::class,
                            VerifyCsrfToken::class,
                            SubstituteBindings::class,
                            DisableBladeIconComponents::class,
                            DispatchServingFilamentEvent::class,
                        ])
        ;
    }
}
