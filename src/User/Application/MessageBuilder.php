<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Domain\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class MessageBuilder
{
    public function __construct(
        private readonly MailerInterface $mailer,
    )
    {
    }

    public function sendRegisterMessage(User $user): void
    {
        $email = (new Email())
            ->from('admin@example.com')
            ->to($user->getEmail())
            ->subject('Email confirmation')
            ->text('Please confirm your email address by visiting this link: NO LINK YET')
            ->html('<p>Please confirm your email address by visiting this <a href="#">NO LINK YET</a></p>');

        $this->mailer->send($email);
    }
}