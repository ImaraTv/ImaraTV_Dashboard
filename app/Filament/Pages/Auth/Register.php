<?php

namespace App\Filament\Pages\Auth;

use Filament\{
    Forms\Components\Select,
    Pages\Auth\Register as BaseRegister
};

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
                                Select::make('role')
                                ->required()
                                ->default('creator')
                                ->options(['creator' => 'Creator', 'sponsor' => 'Sponsor'])
                            ])
                            ->statePath('data'),
            ),
        ];
    }
}
