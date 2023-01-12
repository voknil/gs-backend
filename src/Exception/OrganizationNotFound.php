<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

final class OrganizationNotFound extends DomainException
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct("Organization not found", $code, $previous);
    }
}
