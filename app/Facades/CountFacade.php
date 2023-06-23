<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CountFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'count';
    }
}
