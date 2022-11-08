<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Application\Data\RecoverPasswordData;
use App\User\Application\Data\RegisterUserData;
use App\User\Application\Exception\UserNotFound;
use App\User\Application\Exception\UserVerificationFailed;
use App\User\Domain\Command\RecoverPasswordCommand;
use App\User\Domain\Command\RegisterUserCommand;
use App\User\Domain\Command\VerifyUserCommand;
use App\User\Domain\EmailVerifierInterface;
use App\User\Domain\User;
use App\User\Domain\UserReadStorage;
use App\User\Domain\UserWriteStorage;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;
use Throwable;

final class CommandProcessor
{
    public function __construct(
        private readonly UserWriteStorage            $userWriteStorage,
        private readonly UserReadStorage             $userReadStorage,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EmailVerifierInterface      $emailVerifier,
    )
    {
    }

    /**
     * @throws Exception\UserAlreadyExists
     */
    public function registerUser(RegisterUserCommand $command, string $emailVerifyRoute): RegisterUserData
    {
        $user = $this->createUser($command->getEmail(), $command->getPassword());

        $this->emailVerifier->sendEmailConfirmation($user, $emailVerifyRoute);

        return new RegisterUserData($user);
    }

    /**
     * @throws Exception\UserAlreadyExists
     */
    private function createUser(string $email, string $password, array $roles = []): User
    {
        $user = User::create(Uuid::v4(), $email, []);

        $user->setPassword(
            $this->hashPassword($user, $password)
        );

        $this->userWriteStorage->add($user);

        return $user;
    }

    private function hashPassword(User $user, string $plainTextPassword): string
    {
        return $this->userPasswordHasher->hashPassword($user, $plainTextPassword);
    }

    /**
     * @throws UserVerificationFailed
     */
    public function verifyUser(VerifyUserCommand $command): void
    {
        try {
            $user = $this->getUser(Uuid::fromString($command->getId()));

            if ($user->isVerified()) {
                throw new UserVerificationFailed();
            }

            $this->emailVerifier->handleEmailConfirmation($user, $command->getUri());
        } catch (Throwable $exception) {
            throw new UserVerificationFailed();
        }
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

    /**
     * @throws UserNotFound
     */
    public function recoverPassword(RecoverPasswordCommand $command): RecoverPasswordData
    {
        $user = $this->getUserByEmail($command->getEmail());

        $user->recoverPassword();

        return new RecoverPasswordData(
            $user->getEmail()
        );
    }

    /**
     * @throws UserNotFound
     */
    private function getUserByEmail(string $email): User
    {
        $user = $this->userReadStorage->getByEmail($email);

        if (null === $user) {
            throw new UserNotFound();
        }

        return $user;
    }
}