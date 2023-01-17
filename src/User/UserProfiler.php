<?php

declare(strict_types=1);

namespace App\User;

use App\Entity\User;
use App\Exception\UserLocaleNotSet;
use App\Exception\UserNotUpdated;
use App\Media\Storage\Storage;
use App\Persistence\Repository\UserRepository;
use App\Request\Translation\SetUserLocale as SetUserLocaleRequest;
use App\Request\User\GetCurrentUserProfile as GetUserProfileRequest;
use App\Request\User\UpdateCurrentUserProfile;
use App\Response\Translation\SetUserLocale as SetUserLocaleResponse;
use App\Response\User\GetCurrentUserProfile as GetUserProfileResponse;
use Exception;
use Symfony\Component\Security\Core\Security;

final class UserProfiler
{
    public function __construct(
        private readonly Security       $security,
        private readonly UserRepository $userRepository,
        private readonly Storage        $mediaStorage,
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

    public function getCurrentUserProfile(GetUserProfileRequest $request): GetUserProfileResponse
    {
        return new GetUserProfileResponse(
            $this->getCurrentUser(),
            $this->mediaStorage
        );
    }

    /**
     * @throws UserNotUpdated
     */
    public function updateCurrentUserProfile(UpdateCurrentUserProfile $request): GetUserProfileResponse
    {
        $user = $this->getCurrentUser();

        try {
            $user->update($request);
            $this->userRepository->save($user, true);
        } catch (Exception $exception) {
            throw new UserNotUpdated(previous: $exception);
        }

        return new GetUserProfileResponse($user, $this->mediaStorage);
    }

    public function getCurrentUser(): ?User
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
}
