<?php
namespace Goodspb\LiveSdk\Facades;

use Illuminate\Support\Facades\Facade;

class Live extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Goodspb\\LiveSdk\\Live';
    }
}
