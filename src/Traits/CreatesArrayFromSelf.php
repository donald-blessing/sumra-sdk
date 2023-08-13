<?php

namespace Sumra\SDK\Traits;


use ReflectionClass;

trait CreatesArrayFromSelf
{
    /**
     * @return ReflectionClass
     */
    public static function reflection()
    {
        return new ReflectionClass(static::class);
    }

    /**
     * return all the constant values as an array
     *
     * @return array
     */
    public static function all()
    {
        return array_values(static::allWithKeys());
    }

    /**
     * return all the constants as a key => value array
     *
     * @return array
     */
    public static function allWithKeys()
    {
        return static::reflection()->getConstants();
    }

    /**
     * return all the constants as a flipped key => value array
     *
     * @return array
     */
    public static function allWithKeysFlipped()
    {
        return array_flip(static::allWithKeys());
    }

    /**
     * return all the keys as an array
     *
     * @return array
     */
    public static function allKeys()
    {
        return array_keys(static::allWithKeys());
    }
}
