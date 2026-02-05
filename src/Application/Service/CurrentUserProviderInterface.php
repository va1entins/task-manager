<?php

namespace App\Application\Service;

use App\Domain\User\User;

interface CurrentUserProviderInterface
{
    public function getCurrentUser(): ?User;
}