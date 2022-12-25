<?php

declare(strict_types=1);

namespace App\Request\User;

use App\Request\JsonValidatedRequest;
use App\User\Command\UpdateUser;
use App\User\Enum\Gender;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdateCurrentUserProfile extends JsonValidatedRequest implements UpdateUser
{
    #[Assert\Length(max: 255)]
    protected ?string $firstName = null;

    #[Assert\Length(max: 255)]
    protected ?string $lastName = null;

    #[Assert\Choice(callback: [Gender::class, 'values'])]
    protected ?string $gender = null;

    #[Assert\Date]
    protected ?string $birthDate = null;

    #[Assert\Uuid]
    protected ?string $imageUuid = null;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($this->birthDate);
        } catch (\Throwable $exception) {
            return null;
        }
    }

    public function getImageUuid(): ?Uuid
    {
        try {
            return Uuid::fromString($this->imageUuid);
        } catch (\Throwable) {
            return null;
        }
    }
}
