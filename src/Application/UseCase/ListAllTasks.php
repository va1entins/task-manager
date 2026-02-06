<?php

namespace App\Application\UseCase;

use App\Application\Strategy\TaskListStrategyInterface;

final readonly class ListAllTasks
{
    public function __construct(
        private TaskListStrategyInterface $strategy
    ) {}

    public function execute(): array
    {
        return $this->strategy->getTasks();
    }
}
