<?php

use PHPUnit\Framework\TestCase;
use Domain\ValueObject\UserId;

class UserIdTest extends TestCase
{
    public function testUserIdGeneration()
    {
        $userId = new UserId();
        $this->assertNotEmpty($userId->value());
        $this->assertMatchesRegularExpression('/^[0-9a-fA-F-]{36}$/', $userId->value());
    }
}
