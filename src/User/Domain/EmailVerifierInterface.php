<?php

declare(strict_types=1);

namespace App\User\Domain;

use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

interface EmailVerifierInterface
{
    public function sendEmailConfirmation(User $user, string $verifyEmailRouteName): void;

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(User $user, string $signedUri): void;
}