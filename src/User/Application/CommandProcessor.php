<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Application\Data\RecoverPasswordData;
use App\User\Application\Data\RegisterUserData;
use App\User\Application\Exception\UserNotFound;
use App\User\Domain\Command\RecoverPasswordCommand;
use App\User\Domain\Command\RegisterUserCommand;
use App\User\Domain\User;
use App\User\Domain\UserReadStorage;
use App\User\Domain\UserWriteStorage;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

final class CommandProcessor
{
    public function __construct(
        private readonly UserWriteStorage $userWriteStorage,
        private readonly UserReadStorage $userReadStorage,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    )
    {
    }

    public function registerUser(RegisterUserCommand $command): RegisterUserData
    {
        return new RegisterUserData(
            $this->createUser($command->getEmail(), $command->getPassword())
        );
    }

    public function recoverPassword(RecoverPasswordCommand $command): RecoverPasswordData
    {
        $user = $this->getUserByEmail($command->getEmail());

        $user->recoverPassword();

        return new RecoverPasswordData(
            $user->getEmail()
        );
    }

    private function createUser(string $email, string $password, array $roles = []): User
    {
        $user = User::create(Uuid::v4(), $email, []);

        $user->setPassword(
            $this->hashPassword($user, $password)
        );

        $this->userWriteStorage->add($user);

        return $user;
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

    private function hashPassword(User $user, string $plainTextPassword): string
    {
        return $this->userPasswordHasher->hashPassword($user, $plainTextPassword);
    }
}