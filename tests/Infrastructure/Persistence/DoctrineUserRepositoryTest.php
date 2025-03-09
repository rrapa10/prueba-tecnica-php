<?php

namespace Tests\Infrastructure\Persistence;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\DBAL\DriverManager;
use Domain\Entity\User;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;
use Infrastructure\Persistence\DoctrineUserRepository;

class DoctrineUserRepositoryTest extends TestCase
{
    private DoctrineUserRepository $userRepository;
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        // Configurar Doctrine en memoria para pruebas
        $config = \Doctrine\ORM\ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . "/../../../src/Domain/Entity"],
            true
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

        // Generar esquema de base de datos en memoria
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    public function testSaveAndFindUser(): void
    {
        $user = new User(
            new UserId(),
            new Name("John Doe"),
            new Email("john@example.com"),
            new Password("SecurePassword123!")
        );

        $this->userRepository->save($user);
        $foundUser = $this->userRepository->findById(new UserId($user->id()));

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id(), $foundUser->id());
        $this->assertEquals($user->email(), $foundUser->email());
    }

    public function testDeleteUser(): void
    {
        $user = new User(
            new UserId(),
            new Name("Jane Doe"),
            new Email("jane@example.com"),
            new Password("SecurePass456!")
        );

        $this->userRepository->save($user);
        $this->userRepository->delete(new UserId($user->id()));

        $this->assertNull($this->userRepository->findById(new UserId($user->id())));
    }
}
