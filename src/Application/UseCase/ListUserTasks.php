<?php

namespace App\Application\UseCase;

use App\Application\Strategy\TaskListStrategyInterface;
use App\Domain\User\UserId;

final readonly class ListUserTasks
{
    public function __construct(
        private TaskListStrategyInterface $strategy
    ) {}

    public function execute(UserId $userId): array
    {
        return $this->strategy->getTasks($userId);
    }
}
