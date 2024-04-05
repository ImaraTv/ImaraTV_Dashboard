<?php

namespace App\Providers\Filament;

use App\{
    Filament\Pages\Auth\Register,
    Filament\Pages\EditProfile,
    Models\SocialiteUser,
    Models\User
};
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use Filament\{
    Enums\ThemeMode,
    Http\Middleware\Authenticate,
    Http\Middleware\DisableBladeIconComponents,
    Http\Middleware\DispatchServingFilamentEvent,
    Navigation\MenuItem,
    Navigation\NavigationGroup,
    Pages,
    Panel,
    PanelProvider,
    Support\Colors\Color,
    Widgets
};
use Illuminate\{
    Contracts\Auth\Authenticatable,
    Cookie\Middleware\AddQueuedCookiesToResponse,
    Cookie\Middleware\EncryptCookies,
    Foundation\Http\Middleware\VerifyCsrfToken,
    Routing\Middleware\SubstituteBindings,
    Session\Middleware\AuthenticateSession,
    Session\Middleware\StartSession,
    View\Middleware\ShareErrorsFromSession
};
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use function app_path;
use function asset;

class SuperAdminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel->default()
                        ->id('admin')
                        ->colors([
                            'danger' => Color::Rose,
                            'gray' => Color::Gray,
                            'info' => Color::Blue,
                            'primary' => [
                                50 => '#edf5fa',
                                100 => '#dfeef7',
                                200 => '#b0d1eb',
                                300 => '#85b3de',
                                400 => '#3b72c4',
                                500 => '#0033ab',
                                600 => '#002b99',
                                700 => '#002280',
                                800 => '#001866',
                                900 => '#00114d',
                                950 => '#000a30'
                            ],
                            'success' => Color::Emerald,
                            'warning' => Color::Orange,
                        ])
                        ->font('Ubuntu')
                        ->defaultThemeMode(ThemeMode::Light)
                        ->brandLogo(asset('images/imara_tv_logo_r.png'))
                        ->brandLogoHeight('4rem')
                        ->plugins([
                            FilamentShieldPlugin::make(),
                            FilamentSocialitePlugin::make()
                            // (required) Add providers corresponding with providers in `config/services.php`.
                            ->setProviders([
                                'google' => [
                                    'label' => 'Google',
                                    // Custom icon requires an additional package, see below.
                                    'icon' => 'fab-google',
                                    // (optional) Button color override, default: 'gray'.
                                    'color' => 'primary',
                                    // (optional) Button style override, default: true (outlined).
                                    'outlined' => false,
                                ],
                            ])
                            // (optional) Enable/disable registration of new (socialite-) users.
                            ->setRegistrationEnabled(true)
                            // (optional) Enable/disable registration of new (socialite-) users using a callback.
                            // In this example, a login flow can only continue if there exists a user (Authenticatable) already.
                            ->setRegistrationEnabled(fn(string $provider, SocialiteUserContract $oauthUser, ?Authenticatable $user) => (bool) $user)
                            // (optional) Change the associated model class.
                            ->setUserModelClass(User::class)
                            // (optional) Change the associated socialite class (see below).
                            ->setSocialiteUserModelClass(SocialiteUser::class)
                        ])
                        ->navigationGroups([
                            NavigationGroup::make()
                            ->label('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->collapsed(false),
                        ])
                        ->path('admin')
                        ->registration(Register::class)
                        ->login()
                        ->emailVerification()
                        ->profile()
                        ->userMenuItems([
                            'profile' => MenuItem::make()->url(fn(): string => EditProfile::getUrl())
                        ])
                        ->loginRouteSlug('login')
                        ->registrationRouteSlug('register')
                        ->passwordResetRoutePrefix('password-reset')
                        ->passwordResetRequestRouteSlug('request')
                        ->passwordResetRouteSlug('reset')
                        ->emailVerificationRoutePrefix('email-verification')
                        ->emailVerificationPromptRouteSlug('prompt')
                        ->emailVerificationRouteSlug('verify')
                        ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
                        ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
                        ->pages([
                            Pages\Dashboard::class,
                        ])
                        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
                        ->widgets([
                            Widgets\AccountWidget::class,
                            Widgets\FilamentInfoWidget::class,
                        ])
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
                        ->authMiddleware([
                            Authenticate::class,
        ]);
    }
}
