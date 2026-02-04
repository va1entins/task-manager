<?php

namespace App\Application\UseCase;

use App\Application\Dto\ChangeTaskStatusCommand;
use App\Domain\Repository\TaskRepositoryInterface;

final readonly class ChangeTaskStatus
{
    public function __construct(
        private TaskRepositoryInterface $tasks
    ) {}

    public function execute(ChangeTaskStatusCommand $command): void
    {
        $task = $this->tasks->get($command->taskId);

        if ($task === null) {
            throw new \RuntimeException('Task not found');
        }

        $task->changeStatus($command->status);

        $this->tasks->save($task);
    }
}
