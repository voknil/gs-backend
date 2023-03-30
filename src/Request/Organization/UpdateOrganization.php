<?php

namespace App\Request\Organization;

use App\Request\JsonValidatedRequest;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdateOrganization extends JsonValidatedRequest implements \App\Organization\Command\UpdateOrganization
{
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    protected string $name;

    protected ?string $address = null;

    protected ?string $type = null;

    protected ?string $website = null;

    protected ?string $description = null;

    protected ?string $vk = null;
    protected ?string $facebook = null;
    protected ?string $instagram = null;
    protected ?string $telegram = null;


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
