<?php

namespace Sumra\SDK\Facades;

use Illuminate\Support\Facades\Facade;

class AdminManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AdminManager';
    }
}
