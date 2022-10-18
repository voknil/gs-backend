<?php

namespace App\User\DTO;

use App\User\Interfaces\UserDtoInterface;

class UserDto implements UserDtoInterface
{
    private ?string $name;
    private ?string $surname;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }



    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}