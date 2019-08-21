<?php

namespace App\Repository;

use App\Entity\DistillerieType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DistillerieType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DistillerieType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DistillerieType[]    findAll()
 * @method DistillerieType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistillerieTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DistillerieType::class);
    }

    // /**
    //  * @return DistillerieType[] Returns an array of DistillerieType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DistillerieType
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
