<?php

namespace Domain\ValueObject;

use Domain\Exception\WeakPasswordException;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        if (!$this->isValid($password)) {
            throw new WeakPasswordException("La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.");
        }

        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    private function isValid(string $password): bool
    {
        return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
    }

    public function value(): string
    {
        return $this->password;
    }
}
