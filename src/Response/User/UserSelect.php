<?php

namespace App\Response\User;

interface UserSelect
{
    public function getId(): string;

    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getEmail(): string;
}
