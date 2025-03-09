<?php

namespace Domain\Exception;

use Exception;

class InvalidNameException extends Exception
{
    public function __construct(string $message = "Nombre inválido.")
    {
        parent::__construct($message, 400);
    }
}
