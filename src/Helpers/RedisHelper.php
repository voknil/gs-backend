<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Enum\MailPriority;
use Predis\Client;

/**
 * Class RedisHelper
 * @package App\Helpers
 */
class RedisHelper
{
    /**
     * @return Client
     */
    public static function getConnection(): Client
    {
        return new Client('redis:6379');
    }

    /**
     * @param Client $redis
     */
    public static function closeConnection(Client $redis)
    {
        $redis->quit();
    }

    /**
     * @param int $priority
     * @return string
     */
    public static function crateMailKey(int $priority): string
    {
        return 'mail_' . $priority . '_'. uniqid();
    }
}