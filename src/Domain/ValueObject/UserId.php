<?php

namespace Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class UserId
{
    private string $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        
        if (!Uuid::isValid($this->id)) {
            throw new InvalidArgumentException("ID inválido.");
        }
    }

    public function value(): string
    {
        return $this->id;
    }
}
