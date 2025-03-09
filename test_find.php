<?php

require 'vendor/autoload.php';

use Domain\ValueObject\UserId;
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

// Cambia este ID por uno que esté en tu base de datos
$id = new UserId("cf9056d2-b95d-4058-8f6d-c73fa93f399a");

$user = $userRepo->findById($id);

if ($user) {
    echo "✅ Usuario encontrado:\n";
    echo "ID: " . $user->id() . "\n";
    echo "Nombre: " . $user->name() . "\n";
    echo "Email: " . $user->email() . "\n";
} else {
    echo "❌ No se encontró el usuario con ID: " . $id->value() . "\n";
}
