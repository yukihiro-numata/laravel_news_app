<?php

namespace App\ErrorMaker;

class ApiErrorCode
{
    const COMMON = [
        'INVALID_REQUEST_PARAMETER' => 400,
    ];

    const MESSAGE = [
        400 => 'invalid request parameter',
    ];
}