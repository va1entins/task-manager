<?php

namespace App\Domain\Repository;

use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\User\UserId;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;

    public function get(TaskId $id): ?Task;

    public function findByUserId(UserId $userId): array;

    public function findAll(): array;
}
