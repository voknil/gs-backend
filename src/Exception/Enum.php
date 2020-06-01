<?php


namespace App\Exception;

/**
 * Class Enum
 *
 * @package App\Exception
 */
class Enum
{
    /**
     * @var string
     */
    public const BAD_REQUEST = 'request is invalid';

    /**
     * @var string
     */
    public const USER_ALREADY_EXISTS = 'user_already_exists';
}