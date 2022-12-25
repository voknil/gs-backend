<?php

declare(strict_types=1);

namespace App\User\Command;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

interface UpdateUser
{
    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getGender(): ?string;

    public function getBirthDate(): ?DateTimeImmutable;

    public function getImageUuid(): ?Uuid;
}
