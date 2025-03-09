<?php

use PHPUnit\Framework\TestCase;
use Domain\Entity\User;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;
use DateTimeImmutable;

class UserTest extends TestCase
{
    public function testUserCreation()
    {
        $userId = new UserId();
        $name = new Name("John Doe");
        $email = new Email("johndoe@example.com");
        $password = new Password("SecurePass123!");
        $createdAt = new DateTimeImmutable();

        $user = new User($userId, $name, $email, $password, $createdAt);

        $this->assertEquals($userId->value(), $user->id());
        $this->assertEquals($name->value(), $user->name());
        $this->assertEquals($email->value(), $user->email());
        $this->assertEquals($password->value(), $user->password());
        $this->assertEquals($createdAt->format('c'), $user->createdAt()->format('c'));
    }
}
