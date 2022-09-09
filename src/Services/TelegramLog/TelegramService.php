<?php

namespace Sumra\SDK\Services\TelegramLog;

use Exception;

class TelegramService
{
    /**
     * The Telegram base API URL.
     *
     * @var string
     */
    private string $telegramApiBaseUrl;

    /**
     * The endpoint of send message in Telegram API.
     *
     * @var string
     */
    private string $telegramApiSendMessageEndpoint;

    /**
     * The token of your Telegram Bot that will send the messages.
     *
     * @var string
     */
    private string $telegramBotToken;

    /**
     * The ID of your Telegram group that will receive the messages.
     *
     * @var string
     */
    private string $telegramChatId;

    /**
     * Create a new Telegram service.
     *
     * @param string $telegramBotToken
     * @param string $telegramChatId
     * @param string $telegramApiBaseUrl
     * @return void
     */
    public function __construct(string $telegramBotToken, string $telegramChatId, string $telegramApiBaseUrl)
    {
        $this->telegramApiBaseUrl = $telegramApiBaseUrl . 'bot';
        $this->telegramApiSendMessageEndpoint = 'sendMessage';
        $this->telegramBotToken = $telegramBotToken;
        $this->telegramChatId = $telegramChatId;
    }

    /**
     * Send message to the API.
     *
     * @param string $messageText
     * @return void
     */
    public function sendMessage(string $messageText): ?string
    {
        $telegramApiSendMessageFullUrl = $this->telegramApiBaseUrl . $this->telegramBotToken . '/' . $this->telegramApiSendMessageEndpoint;
        $requestQueryData = $this->prepareRequestQuery($messageText);

        try {
            $responseStatusCode = $this->getResponseStatusCode($telegramApiSendMessageFullUrl . '?' . $requestQueryData);

            return $this->returnResponseOfApiByStatusCode($responseStatusCode);
        } catch (Exception $exception) {
        }
    }

    /**
     * Prepare the request query.
     *
     * @param string $messageText
     * @return string
     */
    private function prepareRequestQuery(string $messageText): string
    {
        return http_build_query([
            'text' => $messageText,
            'chat_id' => $this->telegramChatId,
            'parse_mode' => 'html',
        ]);
    }

    /**
     * Get response status code.
     *
     * @param string $url
     * @return string
     */
    private function getResponseStatusCode(string $url): string
    {
        $requestHeaders = get_headers($url);

        return substr($requestHeaders[0], 9, 3);
    }

    /**
     * Get the response message by status code.
     *
     * @param int $responseStatusCode
     * @return string
     */
    private function returnResponseOfApiByStatusCode($responseStatusCode): ?string
    {
        $responseMessages = [
            '200' => 'Message has been sent.',
            '400' => 'Chat ID is not valid.',
            '401' => 'Bot Token is not valid.',
            '404' => 'Bot Token is not valid.',
        ];

        return $responseMessages[$responseStatusCode] ?? null;
    }
}
