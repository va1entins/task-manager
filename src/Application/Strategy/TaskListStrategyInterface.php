<?php

namespace App\Application\Strategy;

use App\Application\Dto\TaskReadDto;

interface TaskListStrategyInterface
{
    /**
     * @return TaskReadDto[]
     */
    public function getTasks(): array;
}
