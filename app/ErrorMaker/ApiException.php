<?php

namespace App\ErrorMaker;

class ApiException extends \Exception
{
    private $apiErrorData;

    public function setApiErrorData($apiErrorData) {
        $this->apiErrorData = $apiErrorData;
    }

    public function getApiErrorData() {
        return $this->apiErrorData;
    }
}
