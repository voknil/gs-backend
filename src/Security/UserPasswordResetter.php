<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Exception\UserNotFound;
use App\Message\UserPasswordResetEmail;
use App\Persistence\Repository\UserRepository;
use App\Request\UserPasswordReset\Request as UserPasswordResetRequestRequest;
use App\Request\UserPasswordReset\Reset;
use App\Response\UserPasswordReset\Request as UserPasswordResetRequestResponse;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

final class UserPasswordResetter implements UserPasswordResetterInterface
{
    public function __construct(
        private readonly UserRepository               $userRepository,
        private readonly MessageBusInterface          $messageBus,
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly UserPasswordHasherInterface  $passwordHasher,
        private readonly LoggerInterface              $logger,
    )
    {
    }

    public function request(UserPasswordResetRequestRequest $request): UserPasswordResetRequestResponse
    {
        try {
            $user = $this->getUserByEmail($request->getEmail());

            $token = $this->resetPasswordHelper->generateResetToken($user);

            $this->messageBus->dispatch(
                new UserPasswordResetEmail(
                    $token,
                    $user->getEmail()
                )
            );
        } catch (UserNotFound $exception) {
            $this->logger->error(
                sprintf(
                    'User with email %s not found for password reset',
                    $request->getEmail()
                )
            );
        } catch (ResetPasswordExceptionInterface $e) {
            $this->logger->error(
                sprintf(
                    '%s - %s',
                    ResetPasswordExceptionInterface::MESSAGE_PROBLEM_HANDLE,
                    $e->getReason()
                )
            );
        } finally {
            return new UserPasswordResetRequestResponse(
                $request->getEmail()
            );
        }
    }

    public function reset(Reset $request): \App\Response\UserPasswordReset\Reset
    {
        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($request->getToken());

            if (!$user instanceof User) {
                throw new RuntimeException(sprintf('Reset password request must be associated with %s entity', User::class));
            }

            $this->resetPasswordHelper->removeResetRequest($request->getToken());

            $encodedPassword = $this->passwordHasher->hashPassword(
                $user,
                $request->getPlainPassword()
            );

            $user->setPassword($encodedPassword);
            $this->userRepository->add($user);

        } catch (ResetPasswordExceptionInterface $e) {
            $this->logger->error(
                sprintf(
                    '%s - %s',
                    ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE,
                    $e->getReason()
                )
            );
        }

        return new \App\Response\UserPasswordReset\Reset();
    }

    /**
     * @throws UserNotFound
     */
    private function getUserByEmail(string $email): User
    {
        $user = $this->userRepository->getByEmail($email);

        if (null === $user) {
            throw new UserNotFound();
        }

        return $user;
    }
}
