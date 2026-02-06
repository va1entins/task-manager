<?php

namespace App\Application\UseCase;

use App\Application\Dto\ChangeTaskStatusCommand;
use App\Application\Strategy\TaskStatusChangeStrategyInterface;
use App\Domain\Event\DomainEventFactoryInterface;
use App\Domain\Repository\TaskRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class ChangeTaskStatus
{
    public function __construct(
        private TaskRepositoryInterface           $tasks,
        private MessageBusInterface               $bus,
        private DomainEventFactoryInterface       $eventFactory,
        private TaskStatusChangeStrategyInterface $statusStrategy,
    ) {}

    public function execute(ChangeTaskStatusCommand $command): void
    {
        $task = $this->tasks->get($command->taskId);

        if ($task === null) {
            throw new \RuntimeException('Task not found');
        }

        $oldStatus = $task->status();

        $this->statusStrategy->changeStatus(
            $task,
            $command->status
        );

        try {
            $this->tasks->save($task);

            $this->bus->dispatch(
                $this->eventFactory->taskStatusUpdated($task, $oldStatus)
            );
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'Failed to change task status',
                previous: $e
            );
        }
    }
}
