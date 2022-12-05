<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UserPasswordResetEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

#[AsMessageHandler]
class UserPasswordResetEmailHandler
{
    private const URL_SCHEMA = 'https';
    private const RESET_PASSWORD_VERIFY = 'reset-password-verify';

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $serverName,
    )
    {
    }

    public function __invoke(UserPasswordResetEmail $message): void
    {
        $token = $message->getResetPasswordToken();

        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@goodsurfing.org', 'GoodSurfing Team'))
            ->to($message->getEmailTo())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'webUrl' => $this->getUrl($token),
                'resetToken' => $token,
            ]);

        $this->mailer->send($email);
    }

    private function getUrl(ResetPasswordToken $token): string
    {
        // used for split 'localhost, caddy:80'
        $serverName = explode(',',$this->serverName);
        $serverName = $serverName[0] ?? '';

        return sprintf(
            '%s://%s/%s?token=%s',
            self::URL_SCHEMA,
            $serverName,
            self::RESET_PASSWORD_VERIFY,
            $token->getToken(),
        );
    }
}
