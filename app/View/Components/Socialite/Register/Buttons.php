<?php

namespace App\View\Components\Socialite\Register;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\MessageBag;
use Illuminate\View\Component;

class Buttons extends \DutchCodingCompany\FilamentSocialite\View\Components\Buttons
{
    protected string $view = 'components.socialite.register.buttons';

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $messageBag = new MessageBag();

        if (session()->has('filament-socialite-login-error')) {
            $messageBag->add('login-failed', session()->pull('filament-socialite-login-error'));
        }

        return view($this->view, [
            'providers' => $this->socialite->getPlugin()->getProviders(),
            'socialiteRoute' => $this->socialite->getPlugin()->getRoute(),
            'messageBag' => $messageBag,
        ]);
    }
}
