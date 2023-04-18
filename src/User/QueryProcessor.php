<?php

namespace App\User;

use App\Entity\User;
use App\Exception\UserNotFound;
use App\Persistence\Repository\UserRepository;
use App\Request\User\Request;
use App\Response\User\UserForSelect;
use App\Response\User\UserSelect;

final class QueryProcessor
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    public function findUser(Request $request): UserSelect
    {
        $email = $request->getEmail();
        $user = $this->userRepository->getByEmail($email);

        if (null === $user) {
            throw new UserNotFound();
        }

        return new UserForSelect($user);
    }
}
