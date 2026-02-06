<?php

namespace App\Application\Dto;

final readonly class ImportedUserDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ) {}
}