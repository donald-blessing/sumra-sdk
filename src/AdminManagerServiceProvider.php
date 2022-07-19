<?php

namespace Sumra\SDK;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Sumra\SDK\Services\AdminManager;

class AdminManagerServiceProvider extends ServiceProvider
{


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()

    {
        App::singleton('AdminManager', function () {
            return new AdminManager();
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Init AdminManager facade object
        if (!class_exists('AdminManager')) {
            class_alias('\Sumra\SDK\Facades\AdminManager', 'AdminManager');
        }

        // Load migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
