<?php

require 'vendor/autoload.php';

use Domain\Entity\User;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;
use Infrastructure\Persistence\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

// Configurar Doctrine
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
$userRepo = new DoctrineUserRepository($entityManager);

// Crear un nuevo usuario
$user = new User(
    new UserId(),
    new Name("Ricardo Palacios"),
    new Email("ricardo@example.com"),
    new Password("Password@123")
);

$userRepo->save($user);
echo "✅ Usuario guardado con éxito.\n";
