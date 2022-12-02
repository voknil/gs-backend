<?php

declare(strict_types=1);

namespace App\Registration;

use App\Entity\User;
use App\Exception\UserAlreadyExists;
use App\Exception\UserNotFound;
use App\Exception\UserVerificationFailed;
use App\Persistence\Repository\UserRepository;
use App\Request\RegisterUser;
use App\Request\VerifyUser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;
use Throwable;

final class Registrar implements RegistrarInterface
{
    public function __construct(
        private readonly UserRepository              $userStorage,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EmailVerifier               $emailVerifier,
    )
    {
    }

    /**
     * @throws UserAlreadyExists
     */
    public function registerUser(RegisterUser $request): \App\Response\RegisterUser
    {
        $user = $this->createUser($request->getEmail(), $request->getPassword(), $request->getLocale());

        $this->emailVerifier->sendEmailConfirmation($user);

        return new \App\Response\RegisterUser($user);
    }

    /**
     * @throws UserAlreadyExists
     */
    private function createUser(string $email, string $password, string $locale): User
    {
        $user = User::create(Uuid::v4(), $email, $locale);

        $user->setPassword(
            $this->hashPassword($user, $password)
        );

        $this->userStorage->add($user);

        return $user;
    }

    private function hashPassword(User $user, string $plainTextPassword): string
    {
        return $this->userPasswordHasher->hashPassword($user, $plainTextPassword);
    }

    /**
     * @throws UserVerificationFailed
     */
    public function verifyUser(VerifyUser $request): void
    {
        try {
            $user = $this->getUser(Uuid::fromString($request->getId()));

            if ($user->isVerified()) {
                throw new UserVerificationFailed();
            }

            $this->emailVerifier->handleEmailConfirmation($user, $request->getUri());
        } catch (Throwable $exception) {
            throw new UserVerificationFailed();
        }
    }

    /**
     * @throws UserNotFound
     */
    private function getUser(Uuid $id): User
    {
        $user = $this->userStorage->get($id);

        if (null === $user) {
            throw new UserNotFound();
        }

        return $user;
    }
}
