<?php

namespace App\User\Infrastructure\Persistence;

use App\User\Application\Exception\UserAlreadyExists;
use App\User\Domain\User;
use App\User\Domain\UserReadStorage;
use App\User\Domain\UserWriteStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Uid\Uuid;
use function get_class;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserReadStorage, UserWriteStorage
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function get(Uuid $id): ?User
    {
        return
            $this->createQueryBuilder('t')
                ->andWhere('t.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
    }

    public function getByEmail(string $email): ?User
    {
        return
            $this->createQueryBuilder('t')
                ->andWhere('t.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult();
    }

    /**
     * @throws UserAlreadyExists
     */
    public function add(User $user): void
    {
        try {
            $this->save($user, true);
        } catch (UniqueConstraintViolationException $exception) {
            throw new UserAlreadyExists(previous: $exception);
        }
    }

    public function save(User $user, bool $flush = false): void
    {
        $this->getEntityManager()->persist($user);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }
}
