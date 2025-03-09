<?php

namespace Tests\Controller;

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Application\UseCase\RegisterUserUseCase;
use Controller\RegisterUserController;
use Slim\Psr7\Stream;

class RegisterUserControllerTest extends TestCase
{
    public function testRegisterUserSuccessfully()
    {
        $requestFactory = new ServerRequestFactory();
        $responseFactory = new ResponseFactory();

        $body = json_encode([
            "name" => "John Doe",
            "email" => "johndoe@example.com",
            "password" => "SecurePass123!"
        ]);

        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $body);
        rewind($stream);
        $bodyStream = new Stream($stream);

        $request = $requestFactory->createServerRequest('POST', '/register')
            ->withHeader('Content-Type', 'application/json')
            ->withBody($bodyStream);

        $registerUserUseCaseMock = $this->createMock(RegisterUserUseCase::class);
        $registerUserUseCaseMock->expects($this->once())
            ->method('execute')
            ->willReturn(new \Domain\Entity\User(
                new \Domain\ValueObject\UserId(),
                new \Domain\ValueObject\Name("John Doe"),
                new \Domain\ValueObject\Email("johndoe@example.com"),
                new \Domain\ValueObject\Password("SecurePass123!")
            ));

        $controller = new RegisterUserController($registerUserUseCaseMock);
        $response = $controller($request, $responseFactory->createResponse());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson((string) $response->getBody());
    }
}
