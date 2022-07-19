<?php

namespace Sumra\SDK;

use App;
use Illuminate\Support\ServiceProvider;
use Sumra\SDK\Console\PublishSettingsConfigCommand;
use Sumra\SDK\Services\PubSub;

class PubSubServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::singleton('PubSub', function(){
            return new PubSub();
        });

        /**
         * Command
        */
        $this->commands('command.sumra.publish');

        /**
         * Command handler
         */
        $this->app->singleton('command.sumra.publish', function () {
            return new PublishSettingsConfigCommand();
        });
    }

    public function boot() {
        // Init Pubsub facade object
        if (!class_exists('PubSub')) {
            class_alias('\Sumra\SDK\Facades\PubSub', 'PubSub');
        }

        // Load migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish config file
//        $this->publishes([
//            __DIR__ . '../config/pubsub.php' => config_path('pubsub.php'),
//        ]);


        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/pubsub.php', 'pubsub'
        );
    }
}
