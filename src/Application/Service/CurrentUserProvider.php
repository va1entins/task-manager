<?php

namespace App\Application\Service;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class CurrentUserProvider
{
    public function __construct(
        private RequestStack            $requestStack,
        private UserRepositoryInterface $users
    ) {}

    public function getCurrentUser(): ?User
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request) {
            $userId = $request->headers->get('X-USER-ID');

            if ($userId !== null && ctype_digit($userId)) {
                return $this->users->findById(
                    new UserId((int) $userId)
                );
            }
        }

        // fallback — first user
        $all = $this->users->findAll();

        return $all[0] ?? null;
    }
}
