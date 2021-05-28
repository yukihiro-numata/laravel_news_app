<?php

namespace App\Http\DataObjectResources;

use Illuminate\Http\Resources\Json\Resource;

class ApiError extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'error' => [
                'code' => $this->errorCode,
                'message' => $this->errorMessage
            ]
        ];
    }
}
