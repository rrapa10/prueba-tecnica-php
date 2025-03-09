<?php

namespace Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Infrastructure\Persistence\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Domain\Entity\User;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;
use App\Exception\ValidationException;
use App\Exception\NotFoundException;


class UserController
{
    private DoctrineUserRepository $userRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->userRepository = new DoctrineUserRepository($entityManager);
    }

    public function getAllUsers(Request $request, Response $response): Response
    {
        $users = $this->userRepository->findAll();

        // Si no hay usuarios, devolver un JSON vacío []
        if (!$users) {
            $response->getBody()->write(json_encode([]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }

        $usersArray = [];
        foreach ($users as $user) {
            $usersArray[] = [
                'id' => $user->id(),
                'name' => $user->name(),
                'email' => $user->email(),
            ];
        }

        $jsonResponse = json_encode($usersArray);


        if ($jsonResponse === false) {
            $jsonResponse = json_encode(['error' => 'Error al codificar JSON']);
            $response->getBody()->write($jsonResponse);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

        $response->getBody()->write($jsonResponse);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getUserById(Request $request, Response $response, array $args): Response
    {
        $user = $this->userRepository->findById(new UserId($args['id']));

        if (!$user) {
            $response->getBody()->write(json_encode(['error' => 'Usuario no encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode([
            'id' => $user->id(),
            'name' => $user->name(),
            'email' => $user->email(),
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createUser(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        // Validar datos
        $errors = $this->validateUserData($data, true);
        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        // Crear usuario
        $user = new User(
            new UserId(),
            new Name($data['name']),
            new Email($data['email']),
            new Password($data['password'])
        );

        $this->userRepository->save($user);

        $response->getBody()->write(json_encode(['message' => 'Usuario creado con éxito']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function updateUser(Request $request, Response $response, array $args): Response
    {
        $userId = new UserId($args['id']);
        $data = json_decode($request->getBody()->getContents(), true);

        // Buscar usuario
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new NotFoundException("Usuario no encontrado");
        }

        // Validar datos
        $errors = $this->validateUserData($data, false);
        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        // Actualizar los datos permitidos
        if (isset($data['name'])) {
            $user->updateName(new Name($data['name']));
        }
        if (isset($data['email'])) {
            $user->updateEmail(new Email($data['email']));
        }
        if (isset($data['password'])) {
            $user->updatePassword(new Password($data['password']));
        }

        $this->userRepository->save($user);

        $response->getBody()->write(json_encode(['message' => 'Usuario actualizado con éxito']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteUser(Request $request, Response $response, array $args): Response
    {
        $userId = new UserId($args['id']);

        // Buscar el usuario en la base de datos
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            $response->getBody()->write(json_encode(['error' => 'Usuario no encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        // Eliminar el usuario
        $this->userRepository->delete($userId);

        $response->getBody()->write(json_encode(['message' => 'Usuario eliminado con éxito']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function validateUserData(array $data, bool $isNewUser): array
    {
        $errors = [];

        // Validar nombre
        if (!isset($data['name']) || strlen(trim($data['name'])) < 3) {
            $errors[] = 'El nombre es obligatorio y debe tener al menos 3 caracteres.';
        }

        // Validar email
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email es obligatorio y debe tener un formato válido.';
        } elseif ($isNewUser && $this->userRepository->emailExists($data['email'])) {
            $errors[] = 'El email ya está registrado.';
        }

        // Validar contraseña (solo para nuevos usuarios)
        if ($isNewUser) {
            if (
                !isset($data['password']) || strlen($data['password']) < 8 ||
                !preg_match('/[A-Z]/', $data['password']) ||
                !preg_match('/[a-z]/', $data['password']) ||
                !preg_match('/[0-9]/', $data['password'])
            ) {
                $errors[] = 'La contraseña debe tener al menos 8 caracteres, incluir mayúscula, minúscula y número.';
            }
        }

        return $errors;
    }
}
