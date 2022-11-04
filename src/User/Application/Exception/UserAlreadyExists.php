<?php

declare(strict_types=1);

namespace App\User\Application\Exception;

use App\Core\Application\DomainException;

final class UserAlreadyExists extends DomainException
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct("User already exists", $code, $previous);
    }


}