<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

final class UserNotUpdated extends DomainException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("User not updated", $code, $previous);
    }
}
