<?php

namespace App\Repository;

use App\Entity\ImageRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ImageRegion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageRegion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageRegion[]    findAll()
 * @method ImageRegion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRegionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ImageRegion::class);
    }

    // /**
    //  * @return ImageRegion[] Returns an array of ImageRegion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageRegion
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
