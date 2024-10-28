<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Forms\Components\GoogleRecaptcha;
use Filament\{
    Forms\Components\Checkbox,
    Forms\Components\Select,
    Pages\Auth\Register as BaseRegister
};
use Illuminate\Support\Facades\Validator;
use function request;

class Register extends BaseRegister
{

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.auth.register';

    protected function getCachedSubNavigation(){}
    protected function getSubNavigationPosition(){}
    protected function getWidgetData() {}
    protected function getHeader() {}
    protected function getCachedHeaderActions() {}
    protected function getActions() {}
    protected function getActionsLayout(){}
    protected function getBreadcrumbs(){}
    protected function getVisibleHeaderWidgets() {}
    protected function getVisibleFooterWidgets(){}
    protected function getFooter(){}
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
                                    ->options(['creator' => 'Creator', 'sponsor' => 'Sponsor']),
                                GoogleRecaptcha::make('captcha'),
                                Checkbox::make('newsletter_consent')
                                    ->label('')
                                    ->required()
                                    ->hint('By signing up you agree to receive Emails and Newsletters from Imara TV')
                                    ->accepted()
                            ])
                            ->statePath('data'),
            ),
        ];
    }

    public function beforeRegister(): void
    {

    }
}
