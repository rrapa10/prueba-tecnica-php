<?php

require 'vendor/autoload.php';

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

// Obtener todos los usuarios
$users = $userRepo->findAll();

if (count($users) === 0) {
    echo "❌ No hay usuarios en la base de datos.\n";
    exit;
}

echo "✅ Usuarios encontrados:\n";
foreach ($users as $user) {
    echo "ID: " . $user->id() . "\n";
    echo "Nombre: " . $user->name() . "\n";
    echo "Email: " . $user->email() . "\n";
    echo "-----------------------------\n";
}
