<?php

declare(strict_types=1);

namespace App\User;

use App\Entity\User;
use App\Exception\UserLocaleNotSet;
use App\Persistence\Repository\UserRepository;
use App\Request\Translation\SetUserLocale as SetUserLocaleRequest;
use App\Request\User\GetCurrentUserProfile as GetUserProfileRequest;
use App\Response\Translation\SetUserLocale as SetUserLocaleResponse;
use App\Response\User\GetCurrentUserProfile as GetUserProfileResponse;
use Exception;
use Symfony\Component\Security\Core\Security;

final class UserProfiler
{
    public function __construct(
        private readonly Security       $security,
        private readonly UserRepository $userRepository,
    )
    {
    }

    /**
     * @throws UserLocaleNotSet
     */
    public function updateUserLocale(SetUserLocaleRequest $locale): SetUserLocaleResponse
    {
        $user = $this->getCurrentUser();

        if (null === $user) {
            return new SetUserLocaleResponse();
        }

        try {
            $user->setLocale($locale->getLocale());
            $this->userRepository->save($user, true);
            return new SetUserLocaleResponse();
        } catch (Exception $exception) {
            throw new UserLocaleNotSet();
        }
    }

    private function getCurrentUser(): ?User
    {
        $user = $this->security->getUser();

        if (null === $user) {
            return null;
        }

        if (!$user instanceof User) {
            return null;
        }

        return $user;
    }

    public function getCurrentUserProfile(GetUserProfileRequest $request): GetUserProfileResponse
    {
        return new GetUserProfileResponse(
            $this->getCurrentUser()
        );
    }
}
