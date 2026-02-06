<?php

namespace App\Domain\Task;

final readonly class TaskId
{
    public function __construct(
        private string $value
    ) {}

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }
}
