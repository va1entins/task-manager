<?php

namespace App\Application\UseCase;

use App\Application\Dto\ImportedUserDto;
use App\Application\Service\UserImportClientInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;

final readonly class ImportUsersFromApi
{
    public function __construct(
        private UserImportClientInterface $client,
        private UserRepositoryInterface   $users
    ) {}

    public function execute(): int
    {
        $imported = 0;

        $apiUsers = $this->client->fetchUsers();

        foreach ($apiUsers as $apiUser) {
            $dto = new ImportedUserDto(
                id: $apiUser->id,
                name: $apiUser->name,
                email: $apiUser->email
            );

            $user = new User(
                new UserId($dto->id),
                $dto->name,
                $dto->email
            );

            $this->users->save($user);
            $imported++;
        }

        return $imported;
    }
}
