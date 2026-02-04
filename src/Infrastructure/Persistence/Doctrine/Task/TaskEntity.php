<?php

namespace App\Infrastructure\Persistence\Doctrine\Task;

use App\Domain\Enum\TaskStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tasks')]
class TaskEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'string', length: 32)]
    private string $status;

    #[ORM\Column(type: 'string', length: 36)]
    private string $userId;

    public function __construct(
        string $id,
        string $title,
        TaskStatus $status,
        string $userId
    ) {
        $this->id     = $id;
        $this->title  = $title;
        $this->status = $status->value;
        $this->userId = $userId;
    }

    public function changeStatus(TaskStatus $status): void
    {
        $this->status = $status->value;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function status(): TaskStatus
    {
        return TaskStatus::from($this->status);
    }
}
