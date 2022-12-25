<?php

declare(strict_types=1);

namespace App\Util;

trait EnumToArray
{
    public static function array(): array
    {
        return array_combine(static::values(), self::names());
    }

    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }
}
