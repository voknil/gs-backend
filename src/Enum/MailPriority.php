<?php
declare(strict_types=1);

namespace App\Enum;

/**
 * Class MailPriority
 * @package App\Enum
 */
class MailPriority extends BaseEnum
{
    /**
     * @var int
     */
    public const NORMAL = 0;

    /**
     * @var int
     */
    public const HIGH = 1;
}