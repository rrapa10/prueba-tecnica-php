<?php

namespace Domain\Exception;

use Exception;

class InvalidEmailException extends Exception
{
    public function __construct(string $message = "Email inválido.")
    {
        parent::__construct($message, 400);
    }
}
