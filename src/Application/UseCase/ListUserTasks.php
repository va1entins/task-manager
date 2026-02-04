<?php

namespace App\Application\UseCase;

use App\Application\Dto\TaskReadDto;
use App\Domain\Repository\TaskRepositoryInterface;
use App\Domain\User\UserId;

final readonly class ListUserTasks
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * @return TaskReadDto[]
     */
    public function execute(UserId $userId): array
    {
        $tasks = $this->taskRepository->findByUserId($userId);

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
