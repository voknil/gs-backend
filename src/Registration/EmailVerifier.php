<?php

namespace App\Registration;

use App\Entity\User;
use App\Persistence\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Throwable;

class EmailVerifier
{
    public function __construct(
        private readonly VerifyEmailHelperInterface $verifyEmailHelper,
        private readonly MailerInterface            $mailer,
        private readonly LoggerInterface            $logger,
        private readonly UserRepository             $userRepository,
        private readonly string                     $emailFromAddress,
        private readonly string                     $emailFromName,
    )
    {
    }

    public function sendEmailConfirmation(User $user): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->emailFromAddress, $this->emailFromName))
            ->to($user->getEmail())
            ->subject('Please Confirm your Email')
            ->htmlTemplate('registration/confirmation_email.html.twig');

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'app_register_verify',
            (string)$user->getId(),
            $user->getEmail(),
            ['id' => (string)$user->getId(),]
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->send($email);
    }

    private function send(TemplatedEmail $email): void
    {
        try {
            $this->mailer->send($email);
        } catch (Throwable $exception) {
            $this->logger->critical(
                sprintf(
                    'Cannot send verification email due to %s',
                    $exception->getMessage()
                )
            );
            $this->logger->debug(
                $exception->getTraceAsString()
            );
        }
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(User $user, string $signedUri): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($signedUri, $user->getId(), $user->getEmail());

        $user->setIsVerified(true);

        $this->userRepository->save($user, true);
    }
}
