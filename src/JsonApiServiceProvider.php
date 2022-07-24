<?php

namespace Sumra\SDK;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\ResponseFactory;
use Sumra\SDK\Exceptions\Handler;
use Sumra\SDK\Services\JsonApiResponse;

/**
 * Class JsonApiServiceProvider
 *
 * @package Sumra\SDK
 */
class JsonApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(
            ExceptionHandler::class,
            Handler::class
        );

        // Add new method to Response
        ResponseFactory::macro('jsonApi', function ($data = null, $status = 200, $headers = [], $options = 0) {
            return new JsonApiResponse($data, $status, $headers, $options);
        });
    }
}
