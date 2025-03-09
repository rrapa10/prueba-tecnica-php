<?php

use PHPUnit\Framework\TestCase;
use Domain\Entity\User;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Psr7\Headers;
use Slim\Psr7\Uri;
use Slim\Psr7\Stream;
use Infrastructure\Persistence\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Controller\UserController;

class UserApiTest extends TestCase
{
    private $app;
    private $entityManager;
    private $userRepository;

    protected function setUp(): void
    {
        // Configurar Slim
        $this->app = AppFactory::create();

        // Configurar Doctrine
        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . "/../src/Domain/Entity"],
            true,
            null,
            new ArrayAdapter()
        );

        $connection = DriverManager::getConnection([
            'dbname' => 'prueba_tecnica',
            'user' => 'user',
            'password' => 'password',
            'host' => 'mysql',
            'driver' => 'pdo_mysql',
        ]);

        $this->entityManager = new EntityManager($connection, $config);
        $this->userRepository = new DoctrineUserRepository($this->entityManager);

        $userController = new UserController($this->entityManager);

        // Definir rutas de prueba
        $this->app->get('/users', [$userController, 'getAllUsers']);
        $this->app->post('/users', [$userController, 'createUser']);
        $this->app->put('/users/{id}', [$userController, 'updateUser']);
        $this->app->delete('/users/{id}', [$userController, 'deleteUser']);
    }

    private function createRequest(string $method, string $path, array $body = []): Request
    {
        $uri = new Uri('', '', 80, $path);
        $headers = new Headers(['Content-Type' => 'application/json']);
        $stream = fopen('php://temp', 'w+');
        fwrite($stream, json_encode($body));
        rewind($stream);

        return new Request($method, $uri, $headers, [], [], new Stream($stream));
    }

    public function testCreateUser()
    {
        $request = $this->createRequest('POST', '/users', [
            'name' => 'Test User',
            'email' => 'test3@example.com',
            'password' => 'Password@123'
        ]);
        $response = new Response();
        $response = $this->app->handle($request);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testGetAllUsers()
    {

        $request = $this->createRequest('GET', '/users');
        $response = $this->app->handle($request);

        // Obtener el contenido de la respuesta
        $response->getBody()->rewind(); // Reinicia el puntero del stream
        $responseContent = $response->getBody()->getContents();


        $this->assertEquals(200, $response->getStatusCode(), "El código de respuesta no es 200.");
        $this->assertNotEmpty($responseContent, "La respuesta está vacía.");
        $this->assertJson($responseContent, "La respuesta no es un JSON válido.");
    }


    public function testUpdateUser()
    {
        $user = new User(
            new UserId(),
            new Name("Usuario Original"),
            new Email("original3@example.com"),
            new Password("Password@123")
        );

        $this->userRepository->save($user);

        $request = $this->createRequest('PUT', "/users/{$user->id()}", [
            'name' => 'Usuario Modificado',
            'email' => 'modificado3@example.com'
        ]);
        $response = new Response();
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteUser()
    {
        $user = new User(
            new UserId(),
            new Name("Usuario a Eliminar"),
            new Email("delete3@example.com"),
            new Password("Password@123")
        );

        $this->userRepository->save($user);

        $request = $this->createRequest('DELETE', "/users/{$user->id()}");
        $response = new Response();
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateUserWithInvalidData()
    {
        $request = $this->createRequest('POST', '/users', [
            'name' => 'A',
            'email' => 'correo_invalido',
            'password' => '123'
        ]);
        $response = $this->app->handle($request);

        $this->assertEquals(400, $response->getStatusCode());
    }
}
