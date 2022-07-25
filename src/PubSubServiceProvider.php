<?php

namespace Sumra\SDK;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Sumra\SDK\Services\PubSub;

class PubSubServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::singleton('PubSub', function(){
            return new PubSub();
        });
    }

    public function boot() {
        // Init PubSub facade object
        if (!class_exists('PubSub')) {
            class_alias('\Sumra\SDK\Facades\PubSub', 'PubSub');
        }

        // Load migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/pubsub.php', 'pubsub'
        );
    }
}
