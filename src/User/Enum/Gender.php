<?php

declare(strict_types=1);

namespace App\User\Enum;

use App\Util\EnumToArray;

enum Gender: string
{
    use EnumToArray;

    case Male = 'male';
    case Female = 'female';
}
