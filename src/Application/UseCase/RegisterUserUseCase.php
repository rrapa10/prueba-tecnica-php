<?php

namespace Application\UseCase;

use Domain\Entity\User;
use Domain\Repository\UserRepositoryInterface;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Name;
use Domain\ValueObject\Email;
use Domain\ValueObject\Password;
use Domain\Event\UserRegisteredEvent;
use Domain\Exception\UserAlreadyExistsException;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterUserRequest $request): User
    {
        $email = new Email($request->getEmail());

        if ($this->userRepository->findByEmail($email)) {
            throw new UserAlreadyExistsException("El email ya está en uso.");
        }

        $user = new User(
            new UserId(),
            new Name($request->getName()),
            $email,
            new Password($request->getPassword())
        );

        $this->userRepository->save($user);

        // Simulación: Aquí se dispararía un evento UserRegisteredEvent
        // event(new UserRegisteredEvent($user));

        return $user;
    }
}
