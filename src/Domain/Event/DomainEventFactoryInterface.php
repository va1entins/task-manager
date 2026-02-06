<?php

namespace App\Domain\Event;

use App\Domain\Enum\TaskStatus;
use App\Domain\Task\Task;

interface DomainEventFactoryInterface
{
    public function taskCreated(Task $task): TaskCreatedEvent;

    public function taskStatusUpdated(Task $task, TaskStatus $oldStatus): TaskStatusUpdatedEvent;
}