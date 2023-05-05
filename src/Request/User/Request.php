<?php
declare(strict_types=1);

namespace App\Request\User;

use App\Request\JsonValidatedRequest;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

 class Request extends JsonValidatedRequest
{
    protected ?string $id;
    protected ?string $email;

    public function getId(): Uuid
    {
        return Uuid::fromString($this->id);
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
