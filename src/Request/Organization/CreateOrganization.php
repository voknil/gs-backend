<?php

namespace App\Request\Organization;

use App\Request\JsonValidatedRequest;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateOrganization extends JsonValidatedRequest implements \App\Organization\Command\CreateOrganization
{
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    protected string $name;

    protected ?string $description;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
