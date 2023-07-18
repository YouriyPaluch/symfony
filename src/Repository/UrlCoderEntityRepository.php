<?php

namespace App\Repository;

use App\Entity\UrlCoderEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UrlCoderEntity>
 *
 * @method UrlCoderEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlCoderEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlCoderEntity[]    findAll()
 * @method UrlCoderEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlCoderEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlCoderEntity::class);
    }

    public function save(UrlCoderEntity $entity = null, bool $flush = true): void
    {
        if (!is_null($entity)) {
            $this->getEntityManager()->persist($entity);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UrlCoderEntity $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
