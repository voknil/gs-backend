<?php

declare(strict_types=1);

namespace App\User\Command;

use App\User\Enum\Gender;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

interface UpdateUser
{
    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getGender(): ?Gender;

    public function getBirthDate(): ?DateTimeImmutable;

    public function getImageUuid(): ?Uuid;
}
