<?php

namespace App\Infrastructure\EventStore;

use App\Domain\Event\TaskStatusUpdatedEvent;
use Doctrine\DBAL\Connection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class StoreTaskStatusUpdatedEventHandler
{
    public function __construct(
        private Connection $connection
    ) {}

    public function __invoke(TaskStatusUpdatedEvent $event): void
    {
        try {
            $this->connection->insert('event_store', [
                'event_type'  => TaskStatusUpdatedEvent::class,
                'payload'     => json_encode([
                    'task_id'    => (string)$event->taskId->toString(),
                    'old_status' => $event->oldStatus->value,
                    'new_status' => $event->newStatus->value,
                ], JSON_THROW_ON_ERROR),
                'occurred_at' => $event->occurredAt->format('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            // TODO: log event_store persistence failure (do not rethrow)
        }
    }
}
