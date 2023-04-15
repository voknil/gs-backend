<?php
declare(strict_types=1);

namespace App\Request\User;

use App\Request\JsonValidatedRequest;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final class Request extends JsonValidatedRequest
{
    #[Assert\NotBlank]
    protected ?string $id;

    public function getId(): Uuid
    {
        return Uuid::fromString($this->id);
    }
}
