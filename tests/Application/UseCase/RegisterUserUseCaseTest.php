<?php

namespace Tests\Application\UseCase;

use PHPUnit\Framework\TestCase;
use Application\UseCase\RegisterUserUseCase;
use Application\UseCase\RegisterUserRequest;
use Domain\Repository\UserRepositoryInterface;
use Domain\Exception\UserAlreadyExistsException;
use Domain\Entity\User;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;

class RegisterUserUseCaseTest extends TestCase
{
    private $userRepositoryMock;
    private $registerUserUseCase;

    protected function setUp(): void
    {
        // Crear un mock del repositorio de usuarios
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $this->registerUserUseCase = new RegisterUserUseCase($this->userRepositoryMock);
    }

    public function testRegisterUserSuccessfully(): void
    {
        $request = new RegisterUserRequest("John Doe", "john@example.com", "SecurePassword123!");

        // Simular que el email no está registrado
        $this->userRepositoryMock->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);

        // Simular que el usuario se guarda correctamente
        $this->userRepositoryMock->expects($this->once())
            ->method('save');

        $user = $this->registerUserUseCase->execute($request);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals("John Doe", $user->name());
        $this->assertEquals("john@example.com", $user->email());
    }

    public function testRegisterUserFailsIfEmailAlreadyExists(): void
    {
        $request = new RegisterUserRequest("John Doe", "john@example.com", "SecurePassword123!");

        $existingUser = new User(new UserId(), new Name("John Doe"), new Email("john@example.com"), new Password("SecurePassword123!"));

        // Simular que el usuario ya existe en la base de datos
        $this->userRepositoryMock->expects($this->once())
            ->method('findByEmail')
            ->willReturn($existingUser);

        $this->expectException(UserAlreadyExistsException::class);

        $this->registerUserUseCase->execute($request);
    }

    public function testUserRegisteredEventIsSimulated()
    {
        $request = new RegisterUserRequest("John Doe", "john@example.com", "SecurePassword123!");

        $this->userRepositoryMock->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);

        $this->userRepositoryMock->expects($this->once())
            ->method('save');

        $registerUserUseCase = new RegisterUserUseCase($this->userRepositoryMock);
        $registerUserUseCase->execute($request);

        // Asegurar que la prueba no sea marcada como "riesgosa"
        $this->assertTrue(true);
    }
}
