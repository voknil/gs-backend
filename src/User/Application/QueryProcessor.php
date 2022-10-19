<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Application\Data\GetUserProfileData;
use App\User\Application\Exception\UserNotFound;
use App\User\Domain\Command\GetUserProfileCommand;
use App\User\Domain\User;
use App\User\Domain\UserReadStorage;
use Symfony\Component\Uid\Uuid;

final class QueryProcessor
{
    public function __construct(
        private readonly UserReadStorage $userReadStorage,
    )
    {
    }

    /**
     * @throws UserNotFound
     */
    public function getUserProfile(GetUserProfileCommand $command): GetUserProfileData
    {
        return new GetUserProfileData(
            $this->getUser($command->getId())
        );
    }

    /**
     * @throws UserNotFound
     */
    private function getUser(Uuid $id): User
    {
        $user = $this->userReadStorage->get($id);

        if (null === $user) {
            throw new UserNotFound();
        }

        return $user;
    }
}