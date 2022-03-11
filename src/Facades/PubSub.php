<?php

namespace Sumra\SDK\Facades;

use Illuminate\Support\Facades\Facade;

class PubSub extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PubSub';
    }
}
