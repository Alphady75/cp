<?php

namespace App\Repository;

use App\Entity\NouvelleVisite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NouvelleVisite|null find($id, $lockMode = null, $lockVersion = null)
 * @method NouvelleVisite|null findOneBy(array $criteria, array $orderBy = null)
 * @method NouvelleVisite[]    findAll()
 * @method NouvelleVisite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NouvelleVisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NouvelleVisite::class);
    }

    public function countByDate()
    {
        $query = $this->createQueryBuilder('v')
            ->select('SUBSTRING(v.dateNv, 1, 10) as dateVisite, COUNT(v) as count')
            ->groupBy('dateVisite');
        return $query->getQuery()->getResult();
    }

    public function filterByDate($dateMin, $dateMax)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.dateNv >= :from')
            ->andWhere('v.dateNv <= :to')
            ->setParameters([
                'from' => $dateMin,
                'to' => $dateMax,
            ])
            ->getQuery()
            ->getResult();
    }

    public function countFilterByDate($dateMin, $dateMax)
    {
        return $this->createQueryBuilder('v')
            ->select('SUBSTRING(v.dateNv, 1, 10) as dateVisite, COUNT(v) as count')
            ->groupBy('dateVisite')
            ->andWhere('v.dateNv >= :from')
            ->andWhere('v.dateNv <= :to')
            ->setParameters([
                'from' => $dateMin,
                'to' => $dateMax,
            ])
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return NouvelleVisite[] Returns an array of NouvelleVisite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NouvelleVisite
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
