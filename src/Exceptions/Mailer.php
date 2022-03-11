<?php

namespace Sumra\SDK\Exceptions;

use Exception;
use Log;
use function basename;
use function dirname;
use function fclose;
use function fopen;
use function http_build_query;
use function stream_context_create;

class Mailer
{
    const USER_ID = 1;

    private $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    public function send()
    {
        $opts = $this->getOpts();

        $context = stream_context_create($opts);

        $url = $this->getUrl();

        try {
            $fp = fopen($url, 'r', false, $context);
            fclose($fp);
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    private function getOpts()
    {
        $opts = [
            'http' => [
                'method' => "POST",
                'header' => "user-id:" . self::USER_ID . "\r\n",
                'content' => $this->getContent()
            ]
        ];

        return $opts;
    }

    private function getContent()
    {
        $service = $this->getNameOfApp();

        $message = 'Error in service ' . $service . ', file ' . $this->exception->getFile() . ', line ' . $this->exception->getLine();

        $message .= ': ' . $this->exception->getMessage();

        $content =
            [
                'subject' => 'Microservices error: ' . $service
                , 'body' => $message
                , 'emails' => ['igg.ukroffices@gmail.com', 'bibrkacity@gmail.com']
            ];

        Log::info($content);

        return http_build_query($content);
    }

    private function getNameOfApp()
    {
        $filename = __FILE__;
        for ($i = 0; $i < 7; $i++) {
            $filename = dirname($filename);
            if ($filename == '')
                break;
        }
        $name = basename($filename);

        return $name;
    }

    private function getUrl()
    {
        //STUB !
        return 'http://localhost:8003/v1/mail/sender';
    }
}
