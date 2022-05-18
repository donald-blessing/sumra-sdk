<?php

namespace Sumra\SDK;

use App;
use Illuminate\Support\ServiceProvider;

class PubSubServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::singleton('PubSub', function(){
            return new PubSub();
        });
    }

    public function boot() {
        if (!class_exists('PubSub')) {
            class_alias('\Sumra\SDK\Facades\PubSub', 'PubSub');
        }

        // Load migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        /*$this->publishes([
            __DIR__ . '../config/pubsub.php' => config_path('pubsub.php'),
        ]);*/

        $this->mergeConfigFrom(
            __DIR__ . '/../config/pubsub.php', 'pubsub'
        );
    }
}
