<?php

namespace App\Application\UseCase;

use App\Application\Dto\CreateTaskCommand;
use App\Domain\Repository\TaskRepositoryInterface;
use App\Domain\Task\Task;

final readonly class CreateTask
{
    public function __construct(
        private TaskRepositoryInterface $tasks
    ) {}

    public function execute(CreateTaskCommand $command): Task
    {
        $task = Task::create(
            $command->title,
            $command->userId
        );

        $this->tasks->save($task);

        return $task;
    }
}
