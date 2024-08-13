<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;


class GoogleRecaptcha extends Field
{
    protected string $view = 'filament.forms.components.google-recaptcha';


    public function setUp(): void
    {
        parent::setUp();
        $this->rules('required|captcha');
        $this->dehydrated(false);
        $this->label('');
    }

    public function callAfterStateUpdated(): static
    {
        parent::callAfterStateUpdated();

        if (method_exists($this->getLivewire(), 'dispatchFormEvent')) {
            $this->getLivewire()->dispatchFormEvent('resetCaptcha');
        } else {
            $this->getLivewire()->emit('resetCaptcha');
        }

        return $this;
    }
}
