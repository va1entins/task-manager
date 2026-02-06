<?php

namespace App\Application\Strategy;

use App\Domain\Task\Task;
use App\Domain\Enum\TaskStatus;

interface TaskStatusChangeStrategyInterface
{
    public function changeStatus(Task $task, TaskStatus $newStatus): void;
}
