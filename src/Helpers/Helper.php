<?php

namespace Sumra\SDK\Helpers;

/**
 * Class Helper
 * @package Sumra\SDK\Helpers
 */
class Helper
{
    public static function setApiUrlPath($slug = null): array|string|null
    {
        return preg_replace('!/+!', '/', sprintf(
            "/%s/%s/%s",
            env('APP_API_PREFIX', ''),
            env('APP_API_VERSION', ''),
            $slug
        ));
    }
}