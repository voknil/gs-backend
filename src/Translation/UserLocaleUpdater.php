<?php

declare(strict_types=1);

namespace App\Translation;

use App\Entity\User;
use App\Exception\UserLocaleNotSet;
use App\Persistence\Repository\UserRepository;
use App\Request\Translation\SetUserLocale as SetUserLocaleRequest;
use App\Response\Translation\SetUserLocale as SetUserLocaleResponse;
use Symfony\Component\Security\Core\Security;

final class UserLocaleUpdater
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
        $user = $this->security->getUser();

        if (null === $user) {
            return new SetUserLocaleResponse();
        }

        if (!$user instanceof User) {
            return new SetUserLocaleResponse();
        }

        try {
            $user->setLocale($locale->getLocale());
            $this->userRepository->save($user, true);
            return new SetUserLocaleResponse();
        } catch (\Exception $exception) {
            throw new UserLocaleNotSet();
        }
    }
}
