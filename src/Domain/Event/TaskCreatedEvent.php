<?php

namespace App\Domain\Event;

use App\Domain\Task\TaskId;
use App\Domain\User\UserId;
use App\Domain\Enum\TaskStatus;

final readonly class TaskCreatedEvent
{
    public function __construct(
        public TaskId $taskId,
        public UserId $userId,
        public string $title,
        public TaskStatus $status,
        public \DateTimeImmutable $occurredAt,
    ) {}
}
