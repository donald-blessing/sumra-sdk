<?php

namespace Sumra\SDK\Helpers;

/**
 * Class Helper
 * @package Sumra\SDK\Helpers
 */
class Helper
{
    /**
     * @param null $slug
     * @return array|string|null
     */
    public static function setApiUrlPath($slug = null): null|array|string
    {
        return preg_replace('!/+!', '/', sprintf(
            "/%s/%s/%s",
            env('APP_API_PREFIX', ''),
            env('APP_API_VERSION', ''),
            $slug
        ));
    }

    /**
     * @param null $slug
     * @return mixed
     */
    public static function getConfig($slug = null): mixed
    {
        if(is_null($slug)){
            return [];
        }

        return require __DIR__ . "/../../config/{$slug}.php";
    }
}