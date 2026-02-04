<?php

namespace App\Domain\User;

final class User
{
    public function __construct(
        private UserId $id,
        private string $name,
        private string $email
    ) {}

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}
