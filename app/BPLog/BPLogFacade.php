<?php

namespace App\BPLog;

use Illuminate\Support\Facades\Facade;

class BPLogFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'App\BPLog\BPLog';
    }
}