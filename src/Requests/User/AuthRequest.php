<?php


namespace App\Requests\User;


use App\Requests\BaseApiRequest;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AuthRequest
 *
 * @package App\Requests\User
 */
class AuthRequest extends BaseApiRequest
{
    /**
     * @Type("string")
     * @Assert\NotBlank(message="password must be filled")
     * @var string
     */
    private $password;

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

    public function getPassword(): string
    {
        return  $this->password;
    }
}