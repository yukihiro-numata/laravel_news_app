<?php

namespace App\ErrorMaker;

class ErrorMaker
{
    public function occurApiError($errorCode, $wishThrow = true) {
        $apiErrorData = new ApiErrorData( $errorCode, ApiErrorCode::MESSAGE[$errorCode] );
        $exception = new ApiException();
        $exception->setApiErrorData($apiErrorData);

        if ( $wishThrow ) {
            throw $exception;
        }

        return $exception;
    }
}
