<?php

namespace App\Organization\Command;

interface CreateOrganization
{
    public function getName(): string;

    public function getDescription(): ?string;
}
