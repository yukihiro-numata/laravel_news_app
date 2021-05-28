<?php

namespace App\ErrorMaker;

class ApiErrorData
{
    public $errorCode;
    public $errorMessage;

    public function __construct($errorCode, $errorMessage) {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }
}
