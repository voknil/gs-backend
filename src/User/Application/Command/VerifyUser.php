<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Command\VerifyUserCommand;
use Symfony\Component\HttpFoundation\Request;

final class VerifyUser implements VerifyUserCommand
{
    public function getId(): ?string
    {
        return $this->getRequest()->query->get('id');
    }

    private function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    public function getUri(): string
    {
        return $this->getRequest()->getUri();
    }
}