<?php

namespace App\Domain\Repository;

use App\Domain\Task\Task;
use App\Domain\Task\TaskId;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;

    public function get(TaskId $id): ?Task;
}
