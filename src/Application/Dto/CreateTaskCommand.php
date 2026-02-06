<?php

namespace App\Application\Dto;

use App\Domain\User\UserId;

final readonly class CreateTaskCommand
{
    public function __construct(
        public string $title,
        public ?UserId $requestedUserId,
        public UserId $currentUserId,
    ) {}
}
