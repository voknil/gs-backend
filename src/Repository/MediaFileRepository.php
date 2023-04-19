<?php

namespace App\Repository;

use App\Entity\MediaFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaFile>
 *
 * @method MediaFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaFile[]    findAll()
 * @method MediaFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaFile::class);
    }

    public function save(MediaFile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
