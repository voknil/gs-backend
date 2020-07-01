<?php
declare(strict_types=1);

namespace App\Mails;

use Exception;

/**
 * Class Mail
 * @package App\Vo
 */
class BaseMail
{
    /**
     * @var string
     */
    private $to;

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     * @throws Exception
     */
    public function setTo(string $to): void
    {
        if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $this->to = $to;
        } else {
            throw new Exception('not valid user email');
        }
    }
}