<?php

namespace App\Request\Organization;

use App\Request\JsonValidatedRequest;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateOrganization extends JsonValidatedRequest implements \App\Organization\Command\CreateOrganization
{
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    protected string $name;

    protected ?string $address;

    protected ?string $type;

    protected ?string $website;

    protected ?string $description;

    protected ?string $vk;
    protected ?string $facebook;
    protected ?string $instagram;
    protected ?string $telegram;


    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getVk(): ?string
    {
        return $this->vk;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram;
    }
}
