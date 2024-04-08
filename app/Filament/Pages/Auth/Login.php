<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.auth.login';
    
    


    protected function getForms(): array
    {

        return [
            'form' => $this->form(
                    $this->makeForm()
                            ->schema([
                                $this->getEmailFormComponent(),
                                $this->getPasswordFormComponent(),
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
