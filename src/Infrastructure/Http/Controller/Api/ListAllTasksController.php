<?php

namespace App\Infrastructure\Http\Controller\Api;

use App\Application\UseCase\ListAllTasks;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class ListAllTasksController
{
    public function __construct(
        private ListAllTasks $useCase
    ) {}

    public function __invoke(): JsonResponse
    {
        try {
            $tasks = $this->useCase->execute();

            return new JsonResponse(array_map(
                static fn($task) => [
                    'id'     => $task->id,
                    'title'  => $task->title,
                    'status' => $task->status->value,
                    'userId' => $task->userId,
                ],
                $tasks
            ));
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
