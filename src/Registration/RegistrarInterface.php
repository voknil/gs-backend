<?php

declare(strict_types=1);

namespace App\Registration;


use App\Request\RegisterUser;

interface RegistrarInterface
{
    public function registerUser(RegisterUser $request): \App\Response\RegisterUser;
}
