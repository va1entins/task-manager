<?php

namespace App\Application\Strategy;

use App\Application\Dto\TaskReadDto;
use App\Domain\Repository\TaskRepositoryInterface;

final readonly class AllTaskListStrategy implements TaskListStrategyInterface
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function getTasks(): array
    {
        $tasks = $this->taskRepository->findAll();

        return array_map(
            static fn ($task) => new TaskReadDto(
                id: $task->id()->value(),
                title: $task->title(),
                status: $task->status(),
                userId: $task->userId()->value(),
            ),
            $tasks
        );
    }
}
