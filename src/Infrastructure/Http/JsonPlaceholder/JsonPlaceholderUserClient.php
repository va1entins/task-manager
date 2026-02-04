<?php

namespace App\Infrastructure\Http\JsonPlaceholder;

use App\Infrastructure\Http\JsonPlaceholder\Dto\JsonPlaceholderUserDto;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final class JsonPlaceholderUserClient
{
    private const URL = 'https://jsonplaceholder.typicode.com/users';

    public function __construct(
        private readonly HttpClientInterface $client
    ) {}

    /**
     * @return JsonPlaceholderUserDto[]
     */
    public function fetchUsers(): array
    {
        try {
            $response = $this->client->request('GET', self::URL);
            $data = $response->toArray();

            return array_map(
                static fn (array $user) => new JsonPlaceholderUserDto(
                    id: $user['id'],
                    name: $user['name'],
                    email: $user['email'],
                ),
                $data
            );
        } catch (Throwable) {
            return [];
        }
    }
}
