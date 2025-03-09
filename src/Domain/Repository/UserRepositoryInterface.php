<?php

namespace Domain\Repository;

use Domain\Entity\User;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Email;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;

    public function delete(UserId $id): void;
    
    public function findByEmail(Email $email): ?User;
}
