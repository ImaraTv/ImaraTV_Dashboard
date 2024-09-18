<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Auth\Login as BaseLogin;
use App\Events\Login as LoginEvent;

class Login extends BaseLogin
{

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.auth.login';

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();

        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        event(new LoginEvent($user));

        return app(LoginResponse::class);
    }


    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                    $this->makeForm()
                            ->schema([
                                $this->getEmailFormComponent(),
                                $this->getPasswordFormComponent(),
                                $this->getRememberFormComponent(),
                            ])
                            ->statePath('data'),
            ),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
