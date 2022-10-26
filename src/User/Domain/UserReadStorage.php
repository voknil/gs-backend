<?php

declare(strict_types=1);

namespace App\User\Domain;

use Symfony\Component\Uid\Uuid;

interface UserReadStorage
{
    public function get(Uuid $Id): ?User;

    public function getByEmail(string $email): ?User;
}