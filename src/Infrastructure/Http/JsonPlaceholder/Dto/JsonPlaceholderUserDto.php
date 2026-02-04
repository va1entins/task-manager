<?php

namespace App\Infrastructure\Http\JsonPlaceholder\Dto;

final readonly class JsonPlaceholderUserDto
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $email,
    ) {}
}
