<?php

namespace App\Domain\Event;

use App\Domain\Task\TaskId;
use App\Domain\Enum\TaskStatus;

final readonly class TaskStatusUpdatedEvent
{
    public function __construct(
        public TaskId $taskId,
        public TaskStatus $oldStatus,
        public TaskStatus $newStatus,
        public \DateTimeImmutable $occurredAt,
    ) {}
}
