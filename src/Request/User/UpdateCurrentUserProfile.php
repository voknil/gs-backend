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

    #[Assert\Length(max: 255)]
    protected ?string $country = null;

    #[Assert\Length(max: 255)]
    protected ?string $city = null;

    #[Assert\Length(max: 255)]
    protected ?string $locale = null;

    #[Assert\Length(max: 255)]
    protected ?string $phone = null;

    #[Assert\Length(max: 1024)]
    protected ?string $aboutMe = null;

    #[Assert\Length(max: 32)]
    protected ?string $vk = null;

    #[Assert\Length(max: 32)]
    protected ?string $facebook = null;

    #[Assert\Length(max: 32)]
    protected ?string $instagram = null;

    #[Assert\Length(max: 32)]
    protected ?string $telegram = null;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getGender(): ?Gender
    {
        return Gender::tryFrom($this->gender);
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAboutMe(): ?string
    {
        return $this->aboutMe;
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
