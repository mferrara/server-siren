<?php

namespace Mferrara\Siren\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mferrara\Siren\Siren
 */
class Siren extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mferrara\Siren\Siren::class;
    }
}
