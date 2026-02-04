<?php

namespace App\Application\UseCase;

use App\Application\Dto\ChangeTaskStatusCommand;
use App\Domain\Event\TaskStatusUpdatedEvent;
use App\Domain\Repository\TaskRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class ChangeTaskStatus
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
        private MessageBusInterface     $bus,
    ) {}

    public function execute(ChangeTaskStatusCommand $command): void
    {
        $task = $this->tasks->get($command->taskId);

        if ($task === null) {
            throw new \RuntimeException('Task not found');
        }

        $oldStatus = $task->status();

        $task->changeStatus($command->status);

        $this->tasks->save($task);

        $this->bus->dispatch(
            new TaskStatusUpdatedEvent(
                taskId: $task->id(),
                oldStatus: $oldStatus,
                newStatus: $task->status(),
                occurredAt: new \DateTimeImmutable(),
            )
        );
    }
}
