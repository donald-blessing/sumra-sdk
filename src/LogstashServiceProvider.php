<?php

namespace Sumra\SDK;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Sumra\SDK\Services\Logstash\LogstashHandleFactory;

/**
 * Class LogstashServiceProvider
 *
 * Package for logstash logging
 *
 * @package Sumra\SDK
 */
class LogstashServiceProvider extends ServiceProvider
{
    public function __construct($app)
    {
        parent::__construct($app);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/logstash.php', 'logstash'
        );

        $config = config('logstash');

        // Handler
        $streamHandlerFactory = new LogstashHandleFactory();
        $handler = $streamHandlerFactory->createStreamHandler(
            $config['log_type'],
            $config['log_stream'],
            $config['log_level']
        );

        app('Psr\Log\LoggerInterface')->setHandlers([$handler]);
        //app('Psr\Log\LoggerInterface')->pushProcessor(new RequestIdProcessor());

        // Register

        //$this->app->configureMonologUsing(function ($monolog) use ($handler) {
        /** @var Logger $monolog */
        //    $monolog->pushHandler($handler);

        //    return $monolog;
        //});

    }

    /*public function getRotatingLogHandler($maxFiles = 7)
    {
        return (new RotatingFileHandler(storage_path('logs/lumen.log'), $maxFiles))
            ->setFormatter(new LineFormatter(null, null, true, true));
    }*/

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
