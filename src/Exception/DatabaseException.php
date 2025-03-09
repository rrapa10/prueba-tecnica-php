<?php

namespace Exception;

class DatabaseException extends AppException
{
    public function __construct(string $message = "Error en la base de datos.")
    {
        parent::__construct($message, 500);
    }
}
