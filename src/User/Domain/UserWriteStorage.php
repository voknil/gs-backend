<?php

declare(strict_types=1);

namespace App\User\Domain;

interface UserWriteStorage
{
    public function add(User $user): void;
}