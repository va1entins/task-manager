<?php

namespace App\Application\Strategy;

use App\Domain\Task\Task;
use App\Domain\Enum\TaskStatus;

final class DefaultTaskStatusChangeStrategy implements TaskStatusChangeStrategyInterface
{
    public function changeStatus(Task $task, TaskStatus $newStatus): void
    {
        $task->changeStatus($newStatus);
    }
}
