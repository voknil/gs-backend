<?php
declare(strict_types=1);

namespace App\Requests\User;


use App\Requests\BaseApiRequest;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PasswordRecoveryRequest
 * @package App\Requests\User
 */
class PasswordRecoveryRequest  extends BaseApiRequest
{
    /**
     * @Type("string")
     * @Assert\NotBlank(message="email must be filled")
     * @Assert\Email(
     *     message = "The email is not a valid email."
     * )
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}