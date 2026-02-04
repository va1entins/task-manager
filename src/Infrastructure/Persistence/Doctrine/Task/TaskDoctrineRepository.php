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

        return $this->mapToDomain($entity);
    }

    /**
     * @return Task[]
     */
    public function findByUserId(UserId $userId): array
    {
        $entities = $this->em
            ->getRepository(TaskEntity::class)
            ->findBy(['userId' => $userId->value()]);

        return array_map([$this, 'mapToDomain'], $entities);
    }

    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        $entities = $this->em
            ->getRepository(TaskEntity::class)
            ->findAll();

        return array_map([$this, 'mapToDomain'], $entities);
    }

    private function mapToDomain(TaskEntity $entity): Task
    {
        return Task::reconstitute(
            new TaskId($entity->id()),
            $entity->getTitle(),
            $entity->status(),
            new UserId($entity->getUserId())
        );
    }
}
