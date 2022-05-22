<?php

use Monolog\Logger;

return [
    'log_type' => env('LOG_TYPE', 'stream'),
    'log_stream' => env('LOG_STREAM', 'php://stdout'),
    'log_level' => env('LOG_LEVEL', Logger::ERROR)
];
