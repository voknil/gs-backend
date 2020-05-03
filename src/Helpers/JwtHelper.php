<?php


namespace App\Helpers;

use Firebase\JWT\JWT;

/**
 * Class JwtHelper
 *
 * @package App\Helpers
 */
class JwtHelper
{
    /**
     * @param int $userId
     *
     * @return string
     */
    public static function createToken(int $userId): string
    {
        //TODO change to real env key after develop
        $key = 'example_key';

        $payload = [
            'user_id' => $userId
        ];

        JWT::$leeway = \App\Enum\Jwt::LIFETIME;

        return JWT::encode($payload, $key);
    }
}