<?php

use PHPUnit\Framework\TestCase;
use Domain\ValueObject\Email;
use Domain\Exception\InvalidEmailException;

class EmailTest extends TestCase
{
    public function testValidEmail()
    {
        $email = new Email("test@example.com");
        $this->assertEquals("test@example.com", $email->value());
    }

    public function testInvalidEmail()
    {
        $this->expectException(InvalidEmailException::class);
        new Email("invalid-email");
    }
}
