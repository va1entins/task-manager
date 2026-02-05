<?php

namespace App\Infrastructure\Http\Controller\Api;

use App\Application\UseCase\ListUserTasks;
use App\Infrastructure\Http\CurrentUser\HttpHeaderCurrentUserProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class ListUserTasksController
{
    public function __construct(
        private ListUserTasks                 $useCase,
        private HttpHeaderCurrentUserProvider $currentUserProvider
    ) {}

    public function __invoke(): JsonResponse
    {
        try {
            $user = $this->currentUserProvider->getCurrentUser();

            if ($user === null) {
                return new JsonResponse([
                    'error' => 'Unauthenticated'
                ], 401);
            }

            $tasks = $this->useCase->execute($user->id());

            return new JsonResponse(array_map(
                static fn($task) => [
                    'id'     => $task->id,
                    'title'  => $task->title,
                    'status' => $task->status->value,
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
