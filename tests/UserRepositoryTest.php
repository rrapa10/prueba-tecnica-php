<?php

use PHPUnit\Framework\TestCase;
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

class UserRepositoryTest extends TestCase
{
    private EntityManager $entityManager;
    private DoctrineUserRepository $userRepository;

    protected function setUp(): void
    {
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
    }

    public function testSaveUser()
    {
        $user = new User(
            new UserId(),
            new Name("Test User"),
            new Email("test@example.com"),
            new Password("Password@123")
        );

        $this->userRepository->save($user);
        $foundUser = $this->userRepository->findById(new UserId($user->id()));

        $this->assertNotNull($foundUser);
        $this->assertEquals("Test User", $foundUser->name());
        $this->assertEquals("test@example.com", $foundUser->email());
    }

    public function testDeleteUser()
    {
        $user = new User(
            new UserId(),
            new Name("Delete User"),
            new Email("delete@example.com"),
            new Password("Password@123")
        );

        $this->userRepository->save($user);
        $this->userRepository->delete(new UserId($user->id()));

        $foundUser = $this->userRepository->findById(new UserId($user->id()));

        $this->assertNull($foundUser);
    }

    public function testUpdateUser()
    {
        // Crear un usuario de prueba
        $user = new User(
            new UserId(),
            new Name("Usuario Original"),
            new Email("original@example.com"),
            new Password("Password@123")
        );

        $this->userRepository->save($user);

        // Actualizar el usuario
        $user->updateName(new Name("Usuario Modificado"));
        $user->updateEmail(new Email("modificado@example.com"));
        $user->updatePassword(new Password("NuevoPassword@123"));

        $this->userRepository->save($user);

        // Buscar el usuario actualizado
        $updatedUser = $this->userRepository->findById(new UserId($user->id()));

        // Verificar que los cambios se guardaron correctamente
        $this->assertNotNull($updatedUser);
        $this->assertEquals("Usuario Modificado", $updatedUser->name());
        $this->assertEquals("modificado@example.com", $updatedUser->email());
    }
}
