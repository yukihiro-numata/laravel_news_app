<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function usualServe($serviceName, $request, $resourceClass = null) {
        $service = resolve("App\Services\\$serviceName");

        try {
            $serviceRes = $service->serve( $service->requestConvert($request) );
        } catch (\Exception $e) {
            $errorResponse = $this->exceptionToResponse($e);

            // 応答不可な例外は上位にスロー
            if ( !$errorResponse ) {
                throw $e;
            }

            return $errorResponse;
        }

        if ( $resourceClass == null ) {
            return $serviceRes;
        }

        return new $resourceClass( $serviceRes );
    }

    private function exceptionToResponse($exception) {
        if ( $exception instanceof \App\ErrorMaker\ApiException ) {
            return $this->makeApiErrorResponse($exception);
        }

        return null;
    }

    private function makeApiErrorResponse($apiException) {
        return response( new \App\Http\DataObjectResources\ApiError($apiException->getApiErrorData()) )->setStatusCode(400, 'Bad Request');
    }
}
