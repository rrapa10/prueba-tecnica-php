<?php

require 'vendor/autoload.php';

use Slim\Factory\AppFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Controller\RegisterUserController;
use Application\UseCase\RegisterUserUseCase;
use Infrastructure\Persistence\DoctrineUserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = AppFactory::create();

// 📌 Configurar Doctrine
$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__ . "/src/Domain/Entity"],
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

$entityManager = new EntityManager($connection, $config);
$userRepository = new DoctrineUserRepository($entityManager);

// 📌 Instanciar caso de uso y controlador antes de definir la ruta
$registerUserUseCase = new RegisterUserUseCase($userRepository);
$registerUserController = new RegisterUserController($registerUserUseCase);

// 📌 Definir rutas
$app->post('/register', [$registerUserController, '__invoke']);

$app->run();
