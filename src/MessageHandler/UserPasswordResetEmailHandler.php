<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UserPasswordResetEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;

#[AsMessageHandler]
class UserPasswordResetEmailHandler
{
    public function __construct(
        private readonly MailerInterface $mailer,
    )
    {
    }

    public function __invoke(UserPasswordResetEmail $message): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@goodsurfing.org', 'GoodSurfing Team'))
            ->to($message->getEmailTo())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $message->getResetPasswordToken(),
            ]);

        $this->mailer->send($email);
    }
}
