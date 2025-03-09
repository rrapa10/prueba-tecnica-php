<?php

namespace Domain\ValueObject;

use Domain\Exception\InvalidEmailException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException("El email '$email' no es válido.");
        }

        $this->email = $email;
    }

    public function value(): string
    {
        return $this->email;
    }
}
