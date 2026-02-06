<?php

namespace App\Infrastructure\EventStore;

use App\Domain\Event\TaskCreatedEvent;
use Doctrine\DBAL\Connection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class StoreTaskCreatedEventHandler
{
    public function __construct(
        private Connection $connection
    ) {}

    public function __invoke(TaskCreatedEvent $event): void
    {
        try {
            $this->connection->insert('event_store', [
                'event_type'  => TaskCreatedEvent::class,
                'payload'     => json_encode([
                    'task_id' => $event->taskId->toString(),
                    'user_id' => $event->userId->toString(),
                    'title'   => $event->title,
                    'status'  => $event->status->value,
                ], JSON_THROW_ON_ERROR),
                'occurred_at' => $event->occurredAt->format('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            // TODO: log event_store persistence failure (do not rethrow)
        }
    }
}
