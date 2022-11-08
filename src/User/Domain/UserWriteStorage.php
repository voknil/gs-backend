<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Application\Exception\UserAlreadyExists;

interface UserWriteStorage
{
    /**
     * @throws UserAlreadyExists
     */
    public function add(User $user): void;

    public function save(User $user, bool $flush = false): void;
}