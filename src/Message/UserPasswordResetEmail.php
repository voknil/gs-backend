<?php

declare(strict_types=1);

namespace App\Message;

use App\MessageHandler\UserPasswordResetEmailHandler;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

/** @see UserPasswordResetEmailHandler */
class UserPasswordResetEmail
{
    public function __construct(
        private readonly ResetPasswordToken $resetPasswordToken,
        private readonly string             $emailTo,
    )
    {
    }

    public function getResetPasswordToken(): ResetPasswordToken
    {
        return $this->resetPasswordToken;
    }

    public function getEmailTo(): string
    {
        return $this->emailTo;
    }
}
