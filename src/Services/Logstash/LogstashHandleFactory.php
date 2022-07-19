<?php

namespace Sumra\SDK\Services\Logstash;

use Exception;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LogstashHandleFactory
{
    /**
     * Create stream handler
     *
     * @param string|string $type
     * @param string|string $stream
     * @param int|int $level
     * @return StreamHandler
     * @throws Exception
     */
    public function createStreamHandler(string $type = 'stream', string $stream = 'php://stdout', int $level = Logger::ERROR): StreamHandler
    {
        $type = strtolower($type);
        switch ($type) {
            case 'stream':
                $handler = new StreamHandler($stream, $level);

                break;
            case 'logstash':
                $handler = new StreamHandler($stream, $level);
                $handler->setFormatter(
                    new LogstashFormatter(config('name', env('APP_NAME', app('request')->getHost())))
                );
                $handler->pushProcessor(new RequestIdProcessor());

                break;
            default:
                $handler = new StreamHandler('php://stdout', Logger::ERROR);
        }

        return $handler;
    }
}
