<?php

namespace App\Providers\Filament;

use App\{
    Filament\Pages\Auth\Login,
    Filament\Pages\Auth\Register,
    Filament\Pages\EditProfile,
    Models\CreatorProfile,
    Models\SocialiteUser,
    Models\User
};
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Blade;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use Filament\{
    Enums\ThemeMode,
    Http\Middleware\Authenticate,
    Http\Middleware\DisableBladeIconComponents,
    Http\Middleware\DispatchServingFilamentEvent,
    Navigation\MenuItem,
    Navigation\NavigationGroup,
    Pages\Dashboard,
    Panel,
    PanelProvider,
    Support\Colors\Color,
    View\PanelsRenderHook,
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
use function auth;
use function collect;

class SuperAdminPanelProvider extends PanelProvider
{

    public static function profileComplete()
    {
        if (auth()->user()->hasRole('creator')) {
            $profile = CreatorProfile::where(['user_id' => auth()->id()])->first();
            if ($profile) {
                $nc = collect($profile)->except('deleted_at', 'created_at', 'updated_at')
                        ->filter(fn($i) => is_null($i) || $i = "" || strlen($i) == 0)
                        ->count();
                if ($nc == 0) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    public function panel(Panel $panel): Panel
    {

        return $panel->default()
                
                        ->id('admin')
                        ->darkMode(false)
                        ->favicon(asset('images/favicon.png'))
                        ->renderHook(PanelsRenderHook::TOPBAR_START, function () {
                            if (!self::profileComplete()) {
                                $mes = "Please complete your profile to add film projects";
                                return Blade::render("<div class='bg-gray-400 p-2 rounded-lg text-center text-white w-full'>{$mes}</div>");
                            }
                        })
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
                                    'outlined' => true,
                                ],
                            ])
                            // (optional) Enable/disable registration of new (socialite-) users.
                            ->setRegistrationEnabled(false)
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
                        ->path('')
                        ->registration(Register::class)
                        ->login(Login::class)
                                ->passwordReset()
                        ->emailVerification()
                        ->profile(EditProfile::class)
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
                            
                        ])
                        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
                        ->widgets([
                                \App\Filament\Widgets\StatsOverview::class
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
                            \App\Http\Middleware\RedirectIfUnApproved::class
                        ])
                        ->authMiddleware([
                            Authenticate::class,
        ]);
    }
}
