<?php
declare(strict_types=1);

namespace App\Mails;

/**
 * Class ChangePasswordMail
 * @package App\Mails
 */
class ChangePasswordMail extends BaseMail
{
    /**
     * @var string
     */
    private $newPassword;

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     */
    public function setNewPassword(string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }
}