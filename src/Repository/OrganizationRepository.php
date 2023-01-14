<?php

namespace App\Repository;

use App\Entity\Organization;
use App\Exception\OrganizationAlreadyExists;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Organization>
 *
 * @method Organization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organization[]    findAll()
 * @method Organization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organization::class);
    }

    public function get(Uuid $id): ?Organization
    {
        return
            $this->createQueryBuilder('t')
                ->andWhere('t.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
    }

    public function remove(Organization $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws OrganizationAlreadyExists
     */
    public function add(Organization $entity)
    {
        try {
            $this->save($entity, true);
        } catch (UniqueConstraintViolationException $exception) {
            throw new OrganizationAlreadyExists(previous: $exception);
        }
    }

    public function save(Organization $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    public function findOneBySomeField($value): ?Organization
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
