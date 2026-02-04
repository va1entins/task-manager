<?php

namespace App\Infrastructure\Persistence\Doctrine\User;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UserDoctrineRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function save(User $user): void
    {
        try {
            $entity = $this->em->find(UserEntity::class, $user->id()->value());

            if ($entity === null) {
                $entity = new UserEntity(
                    id: $user->id()->value(),
                    name: $user->name(),
                    email: $user->email()
                );

                $this->em->persist($entity);
            }

            $this->em->flush();
        } catch (\Throwable) {
            // TODO: add proper error handling / logging strategy for persistence layer
        }
    }

    public function findById(UserId $id): ?User
    {
        $entity = $this->em->find(UserEntity::class, $id->value());

        return $entity
            ? new User(
                new UserId($entity->id()),
                $entity->name(),
                $entity->email()
            )
            : null;
    }

    public function findAll(): array
    {
        $entities = $this->em
            ->getRepository(UserEntity::class)
            ->findAll();

        return array_map(
            static fn (UserEntity $e) => new User(
                new UserId($e->id()),
                $e->name(),
                $e->email()
            ),
            $entities
        );
    }
}
