<?php

namespace Sumra\SDK\Providers;

use Illuminate\Support\ServiceProvider;

class TelegramLogServiceProvider extends ServiceProvider
{
    /**
     * Register the Telegram Log package.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/logging-telegram.php', 'telegram');
    }

    /**
     * Bootstrap the Telegram Log package.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
