<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

final class VerifyUser
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
