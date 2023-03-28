<?php

namespace App\Organization\Command;

interface CreateOrganization
{
    public function getName(): string;

    public function getAddress(): ?string;

    public function getType(): ?string;

    public function getWebsite(): ?string;

    public function getDescription(): ?string;

    public function getVk(): ?string;

    public function getFacebook(): ?string;

    public function getInstagram(): ?string;

    public function getTelegram(): ?string;
}
