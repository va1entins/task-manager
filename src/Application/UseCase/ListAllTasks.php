<?php

namespace App\Application\UseCase;

use App\Application\Dto\TaskReadDto;
use App\Domain\Repository\TaskRepositoryInterface;

final readonly class ListAllTasks
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * @return TaskReadDto[]
     */
    public function execute(): array
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
