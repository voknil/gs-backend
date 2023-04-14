<?php

namespace App\User;

use App\Entity\User;
use App\Exception\UserNotFound;
use App\Persistence\Repository\UserRepository;
use App\Response\User\UserForSelect;

final class QueryProcessor
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    public function findUserByEmail(string $email): UserForSelect
    {
        $user = $this->userRepository->getByEmail($email);

        if (null === $user) {
            throw new UserNotFound();
        }

        return new UserForSelect($user);
    }
}
