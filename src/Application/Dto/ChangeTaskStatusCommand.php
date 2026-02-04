<?php

namespace App\Application\Dto;

use App\Domain\Enum\TaskStatus;
use App\Domain\Task\TaskId;

final readonly class ChangeTaskStatusCommand
{
    public function __construct(
        public TaskId     $taskId,
        public TaskStatus $status
    ) {}
}
