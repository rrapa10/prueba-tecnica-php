<?php

namespace Domain\ValueObject;

use Domain\Exception\InvalidNameException;

class Name
{
    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 3) {
            throw new InvalidNameException("El nombre debe tener al menos 3 caracteres.");
        }

        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }
}
