<?php

namespace App\Repository;

use App\Entity\WhiskyImg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WhiskyImg|null find($id, $lockMode = null, $lockVersion = null)
 * @method WhiskyImg|null findOneBy(array $criteria, array $orderBy = null)
 * @method WhiskyImg[]    findAll()
 * @method WhiskyImg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WhiskyImgRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WhiskyImg::class);
    }

    // /**
    //  * @return WhiskyImg[] Returns an array of ImageDist objects
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
