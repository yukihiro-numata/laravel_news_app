<?php

namespace App\ErrorMaker;
use Illuminate\Support\Facades\Facade;

class ErrorMakerFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'App\ErrorMaker\ErrorMaker';
    }
}
