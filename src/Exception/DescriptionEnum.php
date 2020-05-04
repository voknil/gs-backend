<?php


namespace App\Exception;


class DescriptionEnum
{
    /**
     * @var string
     */
    public const USER_ALREADY_EXISTS = 'User with this email already exists';

    /**
     * @var string
     */
    public const USER_NOT_FOUND = 'User not found';

    /**
     * @var string
     */
    public const INCORRECT_PASSWORD = 'Incorrect password';

}