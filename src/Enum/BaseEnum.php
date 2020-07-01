<?php
declare(strict_types=1);

namespace App\Enum;

use ReflectionClass;

/**
 * Class BaseEnum
 * @package App\Enum
 */
class BaseEnum
{
    public static function getConstants() {
        $oClass = new ReflectionClass(static::class);
        return $oClass->getConstants();
    }
}