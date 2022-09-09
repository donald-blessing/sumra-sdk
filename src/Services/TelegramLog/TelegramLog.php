<?php

namespace Sumra\SDK\Services\TelegramLog;

use Monolog\Logger;

class TelegramLog
{
    /**
     * Create a new Logger instance.
     *
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        return new Logger(config('app.name'), [
            new TelegramLogHandler($config['level']),
        ]);
    }
}
