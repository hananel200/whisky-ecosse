<?php

namespace App\Repository;

use App\Entity\ImageDist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ImageDist|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageDist|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageDist[]    findAll()
 * @method ImageDist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageDistRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ImageDist::class);
    }

    // /**
    //  * @return ImageDist[] Returns an array of ImageDist objects
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
    public function findOneBySomeField($value): ?ImageDist
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
