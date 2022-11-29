<?php

declare(strict_types=1);

namespace App\Security;

use App\Request\UserPasswordReset\Request;
use App\Request\UserPasswordReset\Reset;

interface UserPasswordResetterInterface
{
    public function request(Request $request): \App\Response\UserPasswordReset\Request;

    public function reset(Reset $request): \App\Response\UserPasswordReset\Reset;
}
