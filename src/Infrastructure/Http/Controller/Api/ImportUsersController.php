<?php

namespace App\Infrastructure\Http\Controller\Api;

use App\Application\UseCase\ImportUsersFromApi;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class ImportUsersController
{
    public function __construct(
        private ImportUsersFromApi $useCase
    ) {}

    public function __invoke(): JsonResponse
    {
        $imported = $this->useCase->execute();

        return new JsonResponse([
            'imported' => $imported,
        ]);
    }
}
