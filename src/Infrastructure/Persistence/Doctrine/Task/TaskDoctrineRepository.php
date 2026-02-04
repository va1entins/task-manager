<?php

namespace App\Infrastructure\Persistence\Doctrine\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Repository\TaskRepositoryInterface;
use App\Domain\User\UserId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class TaskDoctrineRepository implements TaskRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function save(Task $task): void
    {
        $entity = new TaskEntity(
            $task->id()->value(),
            $task->title(),
            $task->status(),
            $task->userId()->value()
        );

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function get(TaskId $id): ?Task
    {
        $entity = $this->em->find(TaskEntity::class, $id->value());

        if ($entity === null) {
            return null;
        }

        return Task::reconstitute(
            new TaskId($entity->id()),
            $entity->title(),
            $entity->status(),
            new UserId($entity->userId())
        );
    }
}
