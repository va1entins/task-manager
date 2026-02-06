<?php

namespace App\Application\UseCase;

use App\Application\Dto\CreateTaskCommand;
use App\Domain\Event\DomainEventFactoryInterface;
use App\Domain\Repository\TaskRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateTask
{
    public function __construct(
        private TaskRepositoryInterface     $tasks,
        private UserRepositoryInterface     $users,
        private MessageBusInterface         $bus,
        private DomainEventFactoryInterface $eventFactory,
    ) {}

    public function execute(CreateTaskCommand $command): Task
    {
        $userId = $command->requestedUserId ?? $command->currentUserId;

        if (! $this->users->exists($userId)) {
            throw new \RuntimeException('User not found');
        }

        $task = Task::create(
            new TaskId((string) Uuid::v7()),
            $command->title,
            $userId
        );

        try {
            $this->tasks->save($task);

            $this->bus->dispatch(
                $this->eventFactory->taskCreated($task)
            );
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'Failed to create task',
                previous: $e
            );
        }

        return $task;
    }
}
