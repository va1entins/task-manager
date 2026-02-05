<?php

namespace App\Application\UseCase;

use App\Application\Strategy\AllTaskListStrategy;
use App\Domain\Repository\TaskRepositoryInterface;

final readonly class ListAllTasks
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(): array
    {
        return (new AllTaskListStrategy($this->taskRepository))->getTasks();
    }
}
