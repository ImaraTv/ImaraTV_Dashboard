<?php

namespace App\Providers;

use Filament\{
    Facades\Filament,
    Navigation\NavigationGroup,
    Support\Assets\Css,
    Support\Facades\FilamentAsset
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([

                        NavigationGroup::make()
                        ->label('Settings')
                        ->icon('heroicon-s-cog')
                        ->collapsed(),
            ]);
        });

        FilamentAsset::register([
            Css::make('flowbyte-css', 'https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css'),
            //Css::make('custom-css', __DIR__ . '/../../resources/css/custom.css'),
        ]);
    }
}
