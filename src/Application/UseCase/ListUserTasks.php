<?php

namespace App\Application\UseCase;

use App\Application\Strategy\UserTaskListStrategy;
use App\Domain\Repository\TaskRepositoryInterface;
use App\Domain\User\UserId;

final readonly class ListUserTasks
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(UserId $userId): array
    {
        $strategy = new UserTaskListStrategy(
            $this->taskRepository,
            $userId
        );

        return $strategy->getTasks();
    }
}
