<?php

namespace App\Application\Dto;

use App\Domain\Enum\TaskStatus;

final readonly class TaskReadDto
{
    public function __construct(
        public string $id,
        public string $title,
        public TaskStatus $status,
        public string $userId,
    ) {}
}
