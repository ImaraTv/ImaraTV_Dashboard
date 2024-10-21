<?php

namespace App\Providers;

use TusPhp\Tus\Server as TusServer;
use Illuminate\Support\ServiceProvider;

class TusServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('tus-server', function ($app) {
            $server = new TusServer();

            $server
                ->setApiPath('/tus') // tus server endpoint.
                ->setUploadDir(storage_path('video-uploads')); // uploads dir.

            return $server;
        });
    }

}
