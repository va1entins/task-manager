<?php

namespace App\Application\Strategy;

use App\Application\Dto\TaskReadDto;
use App\Domain\Repository\TaskRepositoryInterface;
use App\Domain\User\UserId;

final readonly class UserTaskListStrategy implements TaskListStrategyInterface
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private UserId                  $userId,
    ) {}

    public function getTasks(): array
    {
        $tasks = $this->taskRepository->findByUserId($this->userId);

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
