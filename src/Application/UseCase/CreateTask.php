<?php

namespace App\Application\UseCase;

use App\Application\Dto\CreateTaskCommand;
use App\Domain\Event\TaskCreatedEvent;
use App\Domain\Repository\TaskRepositoryInterface;
use App\Domain\Task\Task;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class CreateTask
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
        private MessageBusInterface     $bus,
    ) {}

    public function execute(CreateTaskCommand $command): Task
    {
        $task = Task::create(
            $command->title,
            $command->userId
        );

        $this->tasks->save($task);

        $this->bus->dispatch(
            new TaskCreatedEvent(
                taskId: $task->id(),
                userId: $task->userId(),
                title: $task->title(),
                status: $task->status(),
                occurredAt: new \DateTimeImmutable(),
            )
        );

        return $task;
    }
}
