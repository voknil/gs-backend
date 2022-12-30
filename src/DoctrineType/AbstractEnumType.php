<?php

declare(strict_types=1);

namespace App\DoctrineType;

use BackedEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use LogicException;

abstract class AbstractEnumType extends Type
{
    public const NAME = '';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'TEXT';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }
        return null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (false === enum_exists($this->getEnumsClass(), true)) {
            throw new LogicException("This class should be an enum");
        }

        if (null === $value) {
            return null;
        }
        // 🔥 https://www.php.net/manual/en/backedenum.tryfrom.php
        return $this::getEnumsClass()::tryFrom($value);
    }

    abstract public static function getEnumsClass(): string;
}
