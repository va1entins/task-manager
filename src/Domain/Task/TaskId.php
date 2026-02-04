<?php

namespace App\Domain\Task;

use Symfony\Component\Uid\Uuid;

final readonly class TaskId
{
    public function __construct(
        private string $value
    ) {}

    public static function generate(): self
    {
        return new self(Uuid::v7()->toRfc4122());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }
}
