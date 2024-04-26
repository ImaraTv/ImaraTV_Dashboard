<?php

namespace App\Filament\Pages\Auth;

use Filament\{
    Forms\Components\Select,
    Pages\Auth\Register as BaseRegister
};
use Illuminate\Support\Facades\Validator;
use function request;

class Register extends BaseRegister
{

//    protected static ?string $navigationIcon = 'heroicon-o-document-text';
//
//    protected static string $view = 'filament.pages.auth.register';


    protected function getForms(): array
    {
        $validator = Validator::make(request()->all(), [
                    'r' => 'in:creator,sponsor'
        ]);
        if ($validator->fails()) {
            $role = 'creator';
        } else {
            $role = request()->get('r', 'creator');
        }
        return [
            'form' => $this->form(
                    $this->makeForm()
                            ->schema([
                                $this->getNameFormComponent(),
                                $this->getEmailFormComponent(),
                                $this->getPasswordFormComponent(),
                                $this->getPasswordConfirmationFormComponent(),
                                Select::make('role')
                                ->label('Register as?')
                                ->required()
                                ->default($role)
                                ->options(['creator' => 'Creator', 'sponsor' => 'Sponsor'])
                            ])
                            ->statePath('data'),
            ),
        ];
    }
}
