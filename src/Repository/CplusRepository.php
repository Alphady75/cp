<?php

namespace App\Repository;

use App\Entity\Cplus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cplus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cplus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cplus[]    findAll()
 * @method Cplus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CplusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cplus::class);
    }

    // /**
    //  * @return Cplus[] Returns an array of Cplus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cplus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
