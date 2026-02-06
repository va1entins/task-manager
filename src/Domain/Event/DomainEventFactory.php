<?php

namespace App\Domain\Event;

use App\Domain\Task\Task;
use App\Domain\Enum\TaskStatus;

final class DomainEventFactory implements DomainEventFactoryInterface
{
    public function taskCreated(Task $task): TaskCreatedEvent
    {
        return new TaskCreatedEvent(
            taskId: $task->id(),
            userId: $task->userId(),
            title: $task->title(),
            status: $task->status(),
            occurredAt: new \DateTimeImmutable(),
        );
    }

    public function taskStatusUpdated(
        Task $task,
        TaskStatus $oldStatus
    ): TaskStatusUpdatedEvent {
        return new TaskStatusUpdatedEvent(
            taskId: $task->id(),
            oldStatus: $oldStatus,
            newStatus: $task->status(),
            occurredAt: new \DateTimeImmutable(),
        );
    }
}
