<?php

namespace App\Infrastructure\Http\Controller\Api;

use App\Application\Dto\ChangeTaskStatusCommand;
use App\Application\UseCase\ChangeTaskStatus;
use App\Domain\Enum\TaskStatus;
use App\Domain\Task\TaskId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final readonly class ChangeTaskStatusController
{
    public function __construct(
        private ChangeTaskStatus $useCase
    ) {}

    public function __invoke(string $taskId, Request $request): JsonResponse
    {
        try {
            $data = json_decode(
                $request->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            if (!isset($data['status'])) {
                throw new BadRequestHttpException('Missing status');
            }

            try {
                $status = TaskStatus::from(strtolower($data['status']));
            } catch (\ValueError) {
                throw new BadRequestHttpException('Invalid task status');
            }

            $command = new ChangeTaskStatusCommand(
                taskId: new TaskId($taskId),
                status: $status
            );

            $this->useCase->execute($command);

            return new JsonResponse([
                'id'     => $taskId,
                'status' => $status->value,
            ]);

        } catch (\Throwable $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                400
            );
        }
    }
}
