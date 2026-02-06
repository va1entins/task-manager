<?php

namespace App\Application\Service;

use App\Infrastructure\Http\JsonPlaceholder\Dto\JsonPlaceholderUserDto;

interface UserImportClientInterface
{
    /**
     * @return JsonPlaceholderUserDto[]
     */
    public function fetchUsers(): array;
}