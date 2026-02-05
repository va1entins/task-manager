<?php

namespace App\Infrastructure\Http\Controller\Api;

use App\Application\Dto\CreateTaskCommand;
use App\Application\UseCase\CreateTask;
use App\Application\Service\CurrentUserProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class CreateTaskController
{
    public function __construct(
        private CreateTask          $useCase,
        private CurrentUserProvider $currentUserProvider
    ){}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $data = json_decode(
                $request->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $user = $this->currentUserProvider->getCurrentUser();

            if ($user === null) {
                return new JsonResponse([
                    'error' => 'Unauthenticated'
                ], 401);
            }

            $command = new CreateTaskCommand(
                title: $data['title'] ?? '',
                userId: $user->id()
            );

            $task = $this->useCase->execute($command);

            return new JsonResponse([
                'id'     => $task->id()->value(),
                'title'  => $task->title(),
                'status' => $task->status()->value,
            ]);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
