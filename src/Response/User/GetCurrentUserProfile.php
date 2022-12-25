<?php

declare(strict_types=1);

namespace App\Response\User;

use App\Entity\User;
use App\User\Enum\Gender;
use DateTimeImmutable;

final class GetCurrentUserProfile
{
    public function __construct(
        private readonly User $user,
    )
    {
    }

    public function getId(): string
    {
        return (string)$this->user->getId();
    }

    public function getLocale(): string
    {
        return $this->user->getLocale();
    }

    public function getEmail(): string
    {
        return $this->user->getEmail();
    }

    public function getFirstName(): ?string
    {
        return $this->user->getFirstName();
    }

    public function getLastName(): ?string
    {
        return $this->user->getLastName();
    }

    public function getGender(): ?Gender
    {
        return $this->user->getGender();
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->user->getBirthDate();
    }

//    public function getImageUuid(): ?Uuid
//    {
//        return $this->user->getImageUuid();
//    }
}
