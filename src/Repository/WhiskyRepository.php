<?php

namespace App\Repository;

use App\Entity\Whisky;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Distillerie;

/**
 * @method Whisky|null find($id, $lockMode = null, $lockVersion = null)
 * @method Whisky|null findOneBy(array $criteria, array $orderBy = null)
 * @method Whisky[]    findAll()
 * @method Whisky[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WhiskyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Whisky::class);
    }

    public function findByRegion($region_id)
    {
        return $this->createQueryBuilder('w')
            ->leftJoin("w.distillerie", "d")
            ->leftJoin("d.region", "r")
            ->where("r.id = $region_id")
            ->andWhere("w.actif = true")
            ->getQuery();
    }

    public function findByDistillerie($id_dist)
    {
        return $this->createQueryBuilder('w')
            ->where("w.actif = true")
            ->andWhere('w.distillerie = :id_dist')
            ->setParameter('id_dist', $id_dist)
            ->getQuery();
    }

    public function myFindAll($order = null)
    {
        if ($order == null){
            return $this->createQueryBuilder('w')
                ->where("w.actif = true")
                ->getQuery();
        }
        else{
            return $this->createQueryBuilder('w')
                ->orderBy('w.prix', $order)
                ->getQuery();
        }

    }

    public function myFindAllAsc()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.prix', 'ASC')
            ->getQuery();
    }

    public function myFindAllDsc()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.prix', 'DESC')
            ->getQuery();
    }


    public function search($keyword)
    {
        return $this->createQueryBuilder('w')
            ->where('w.nom LIKE :key')
            ->andWhere("w.actif = true")
            ->setParameter('key' , '%'.$keyword.'%')
            ->getQuery();
    }

    // /**
    //  * @return Whisky[] Returns an array of Whisky objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

}
