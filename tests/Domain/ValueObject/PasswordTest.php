<?php

use PHPUnit\Framework\TestCase;
use Domain\ValueObject\Password;
use Domain\Exception\WeakPasswordException;

class PasswordTest extends TestCase
{
    public function testValidPassword()
    {
        $password = new Password("SecurePass123!");
        $this->assertNotEmpty($password->value());
    }

    public function testWeakPassword()
    {
        $this->expectException(WeakPasswordException::class);
        new Password("123456");
    }
}
