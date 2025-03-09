<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require_once 'vendor/autoload.php';

// Configurar Doctrine con caché personalizada
$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__ . "/src/Domain/Entity"], // Paths
    true, // Dev mode
    null, // Proxy directory
    new ArrayAdapter() // Cache
);

$connection = DriverManager::getConnection([
    'dbname' => 'prueba_tecnica',
    'user' => 'user',
    'password' => 'password',
    'host' => 'mysql',
    'driver' => 'pdo_mysql',
]);

$entityManager = new EntityManager($connection, $config);

// Corrección: Usar SingleManagerProvider
ConsoleRunner::run(new SingleManagerProvider($entityManager));
