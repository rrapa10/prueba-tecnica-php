<?php

namespace Domain\Exception;

use Exception;

class ValidationException extends Exception
{
    public function __construct(string $message = "Datos inválidos.", int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
