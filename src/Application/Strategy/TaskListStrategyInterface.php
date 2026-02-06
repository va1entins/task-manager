<?php

namespace App\Application\Strategy;

use App\Application\Dto\TaskReadDto;
use App\Domain\User\UserId;

interface TaskListStrategyInterface
{
    /**
     * @return TaskReadDto[]
     */
    public function getTasks(?UserId $userId = null): array;
}
