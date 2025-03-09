<?php

namespace App\Exception;

class ValidationException extends AppException
{
    public function __construct(array $errors)
    {
        parent::__construct(json_encode(['errors' => $errors]), 400);
    }
}
