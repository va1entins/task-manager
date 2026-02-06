<?php

namespace App\Infrastructure\Http\Controller\Api;

use App\Application\Dto\CreateTaskCommand;
use App\Application\Service\CurrentUserProviderInterface;
use App\Application\UseCase\CreateTask;
use App\Domain\User\UserId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class CreateTaskController
{
    public function __construct(
        private CreateTask                   $useCase,
        private CurrentUserProviderInterface $currentUserProvider,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $data = json_decode(
                $request->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $currentUser = $this->currentUserProvider->getCurrentUser();

            if ($currentUser === null) {
                return new JsonResponse([
                    'error' => 'Unauthenticated',
                ], 401);
            }

            $command = new CreateTaskCommand(
                title: $data['title'] ?? '',
                requestedUserId: isset($data['userId'])
                    ? new UserId((string) $data['userId'])
                    : null,
                currentUserId: $currentUser->id()
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
