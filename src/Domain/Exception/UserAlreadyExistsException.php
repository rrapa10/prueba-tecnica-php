<?php

namespace Domain\Exception;

use Exception;

class UserAlreadyExistsException extends Exception
{
    public function __construct(string $message = "El usuario ya existe.")
    {
        parent::__construct($message, 400);
    }
}
