<?php

namespace App\Repository;

use App\Entity\Distillerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Distillerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Distillerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Distillerie[]    findAll()
 * @method Distillerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistillerieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Distillerie::class);
    }

    public function findByRegion($region_id)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.region = :region_id')
            ->setParameter('region_id', $region_id)
            ->getQuery()
            ->getResult();
    }




    // /**
    //  * @return Distillerie[] Returns an array of Distillerie objects
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
    public function findOneBySomeField($value): ?Distillerie
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
