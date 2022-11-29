<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

abstract class DomainException extends Exception
{
    public function getContent(): array
    {
        return ['message' => $this->getMessage()];
    }
}
