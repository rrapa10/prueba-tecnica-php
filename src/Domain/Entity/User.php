<?php

namespace Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 36, unique: true)]
    private string $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $name;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    private string $password;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $createdAt;

    public function __construct(UserId $id, Name $name, Email $email, Password $password, DateTimeImmutable $createdAt = null)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->email = $email->value();
        $this->password = $password->value();
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }

    public function id(): string { return $this->id; }
    public function name(): string { return $this->name; }
    public function email(): string { return $this->email; }
    public function password(): string { return $this->password; }
    public function createdAt(): DateTimeImmutable { return $this->createdAt; }

    // Métodos de actualización
    public function updateName(Name $name): void
    {
        $this->name = $name->value();
    }

    public function updateEmail(Email $email): void
    {
        $this->email = $email->value();
    }

    public function updatePassword(Password $password): void
    {
        $this->password = $password->value();
    }
}
