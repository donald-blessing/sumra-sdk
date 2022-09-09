<?php

namespace Sumra\SDK\Services\TelegramLog;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramLogHandler extends AbstractProcessingHandler
{
    /**
     * The application URL.
     *
     * @var string
     */
    protected $applicationUrl;

    /**
     * The application name.
     *
     * @var string
     */
    private $applicationName;

    /**
     * The application environment.
     *
     * @var string
     */
    private $applicationEnvironment;

    /**
     * The instance of TelegramService
     */
    private $telegramService;

    /**
     * Create a new TelegramLoggerHandler instance.
     *
     * @param string $logLevel
     * @return void
     */
    public function __construct(string $logLevel)
    {
        $monologLevel = Logger::toMonologLevel($logLevel);
        parent::__construct($monologLevel, true);

        $this->applicationName = config('app.name');
        $this->applicationEnvironment = config('app.env');
        $this->applicationUrl = config('app.url');

        $this->telegramService = new TelegramService(
            config('telegram.bot_token'),
            config('telegram.chat_id'),
            config('telegram.base_url')
        );
    }

    /**
     * Send formatted log to the service.
     *
     * @param array $record
     * @return void
     */
    protected function write(array $record): void
    {
        $this->telegramService->sendMessage($this->formatLogText($record));
    }

    /**
     * Format the log
     *
     * @param array $log
     * @return string
     */
    protected function formatLogText(array $log): string
    {
        $logText = '<b>📌 Application:</b> ' . $this->applicationName . PHP_EOL;
        $logText .= '<b>♻️ Environment:</b> ' . $this->applicationEnvironment . PHP_EOL;
        // $logText .= '<b>🔗 URL:</b> ' . $this->applicationUrl . PHP_EOL;
        $logText .= '<b>⚠️ Log Level:</b> ' . $log['level_name'] . PHP_EOL;
        $logText .= '<b>🕒 Timestamp:</b> ' . $log['datetime']->format('Y-m-d H:i:s') . PHP_EOL;

        if (!empty($log['extra'])) {
            $logText .= '<b>🧪 Extra:</b>' . PHP_EOL . '<code>' . json_encode($log['extra']) . '</code>' . PHP_EOL;
        }

        $log_arr = explode(' ', $log['formatted']);
        $message = implode(' ', array_slice($log_arr, 2));

        $logText .= '<b>✉️ Message:</b>' . PHP_EOL . '<pre>' . $message . '</pre>';

        return $logText;
    }
}
