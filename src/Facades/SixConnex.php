<?php


namespace LaravelSixConnex\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SixConnex
 */
class SixConnex extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LaravelSixConnex\SixConnexApi::class ;
    }
}
