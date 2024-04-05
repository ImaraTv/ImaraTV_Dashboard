<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{

//    protected static ?string $navigationIcon = 'heroicon-o-document-text';
//
//    protected static string $view = 'filament.pages.auth.register';


    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                    $this->makeForm()
                            ->schema([
                                $this->getNameFormComponent(),
                                $this->getEmailFormComponent(),
                                $this->getPasswordFormComponent(),
                                $this->getPasswordConfirmationFormComponent(),
                            ])
                            ->statePath('data'),
            ),
        ];
    }
    
}
