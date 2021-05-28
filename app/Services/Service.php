<?php

namespace App\Services;

class Service
{
    public function serve($data) {}

    protected function validatorToErrorString($validator) {
        return $validator->errors()->toJson();
    }
}