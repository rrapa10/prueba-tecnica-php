<?php

use PHPUnit\Framework\TestCase;
use Domain\ValueObject\Name;
use Domain\Exception\InvalidNameException;

class NameTest extends TestCase
{
    public function testValidName()
    {
        $name = new Name("John Doe");
        $this->assertEquals("John Doe", $name->value());
    }

    public function testInvalidName()
    {
        $this->expectException(InvalidNameException::class);
        new Name("A"); // Nombre demasiado corto
    }
}
