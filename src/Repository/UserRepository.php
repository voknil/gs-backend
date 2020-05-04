<?php

namespace App\Repository;

use App\Exception\User\PasswordIncorrectException;
use App\Exception\User\UserNotFoundException;
use App\Requests\User\AuthRequest;
use App\Requests\User\UserRegistrationRequest;
use App\Entity\User;
use App\Exception\DescriptionEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Exception\User\UserAlreadyExistsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ManagerRegistry $registry,
                                UserPasswordEncoderInterface $encoder,
                                EntityManagerInterface $entityManager
    ) {
        $this->encoder       = $encoder;
        $this->entityManager = $entityManager;
        parent::__construct($registry, User::class);
    }

    /**
     * @param UserRegistrationRequest $request
     *
     * @return User
     * @throws UserAlreadyExistsException
     */
    public function register(UserRegistrationRequest $request): User
    {
        $this->checkEmail($request->getEmail());

        $user = new User();
        $user->setEmail($request->getEmail());
        $encodedPass = $this->encoder->encodePassword($user, $request->getPassword());
        $user->setPassword($encodedPass);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param AuthRequest $request
     *
     * @return User|null
     * @throws UserNotFoundException
     * @throws PasswordIncorrectException
     */
    public function auth(AuthRequest $request): User
    {
        $existsUser = $this->findOneBy(['email' => $request->getEmail()]);

        if (!$existsUser) {
            throw new UserNotFoundException(DescriptionEnum::USER_NOT_FOUND);
        }

        if(!$this->encoder->isPasswordValid($existsUser, $request->getPassword())) {
            throw  new PasswordIncorrectException(DescriptionEnum::INCORRECT_PASSWORD);
        }

        return $existsUser;
    }

    /**
     * @param string $email
     *
     * @throws UserAlreadyExistsException
     */
    private function checkEmail(string $email): void
    {
        $existsUser = $this->findOneBy(['email' => $email]);

        if ($existsUser) {
            throw new UserAlreadyExistsException(DescriptionEnum::USER_ALREADY_EXISTS);
        }
    }
}
