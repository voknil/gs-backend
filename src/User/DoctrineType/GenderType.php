<?php

declare(strict_types=1);

namespace App\User\DoctrineType;

use App\DoctrineType\AbstractEnumType;
use App\User\Enum\Gender;

class GenderType extends AbstractEnumType
{
    public const NAME = 'gender';

    public static function getEnumsClass(): string // the enums class to convert
    {
        return Gender::class;
    }

    public function getName(): string // the name of the type.
    {
        return self::NAME;
    }
}
