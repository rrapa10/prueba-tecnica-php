<?php

namespace Domain\Exception;

use Exception;

class WeakPasswordException extends Exception
{
    public function __construct(string $message = "Contraseña débil.")
    {
        parent::__construct($message, 400);
    }
}
