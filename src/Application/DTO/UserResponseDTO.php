<?php

namespace Application\DTO;

use Domain\Entity\User;

class UserResponseDTO
{
    public string $id;
    public string $name;
    public string $email;
    public string $createdAt;

    public function __construct(User $user)
    {
        $this->id = $user->id();
        $this->name = $user->name();
        $this->email = $user->email();
        $this->createdAt = $user->createdAt()->format('c');
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "createdAt" => $this->createdAt,
        ];
    }
}
