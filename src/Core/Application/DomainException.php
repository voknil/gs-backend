<?php

declare(strict_types=1);

namespace App\Core\Application;

abstract class DomainException extends \Exception
{
    public function getContent(): array
    {
        return ['message' => $this->getMessage()];
    }
}