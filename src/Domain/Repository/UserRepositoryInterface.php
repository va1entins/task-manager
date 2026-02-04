<?php

namespace App\Domain\Repository;

use App\Domain\User\User;
use App\Domain\User\UserId;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;

    /**
     * @return User[]
     */
    public function findAll(): array;
}
