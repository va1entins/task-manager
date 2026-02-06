<?php

namespace App\Domain\Task;

use App\Domain\Enum\TaskStatus;
use App\Domain\User\UserId;

final class Task
{
    private TaskId $id;
    private string $title;
    private TaskStatus $status;
    private UserId $userId;

    private function __construct(
        TaskId $id,
        string $title,
        UserId $userId
    ) {
        $this->id     = $id;
        $this->title  = $title;
        $this->userId = $userId;
        $this->status = TaskStatus::TODO;
    }

    public static function create(
        TaskId $id,
        string $title,
        UserId $userId
    ): self {
        return new self(
            $id,
            $title,
            $userId
        );
    }

    public function changeStatus(TaskStatus $status): void
    {
        if ($this->status === $status) {
            return;
        }

        $this->status = $status;
    }

    public function id(): TaskId
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function status(): TaskStatus
    {
        return $this->status;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public static function reconstitute(
        TaskId $id,
        string $title,
        TaskStatus $status,
        UserId $userId
    ): self {
        $task = new self(
            $id,
            $title,
            $userId
        );

        $task->status = $status;

        return $task;
    }
}
