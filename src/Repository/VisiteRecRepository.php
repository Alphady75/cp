<?php

namespace App\Repository;

use App\Entity\VisiteRec;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisiteRec|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisiteRec|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisiteRec[]    findAll()
 * @method VisiteRec[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRecRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisiteRec::class);
    }

    public function countByDate(){
        $query = $this->createQueryBuilder('v')
            ->select('SUBSTRING(v.dateRec, 1, 10) as dateVisite, COUNT(v) as count')
            ->groupBy('dateVisite')
        ;
        return $query->getQuery()->getResult();
    }

    public function filterByDate($dateMin, $dateMax)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.dateRec >= :from')
            ->andWhere('v.dateRec <= :to')
            ->setParameters([
                'from' => $dateMin,
                'to' => $dateMax,
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    public function countFilterByDate($dateMin, $dateMax)
    {
        return $this->createQueryBuilder('v')
            ->select('SUBSTRING(v.dateRec, 1, 10) as dateVisite, COUNT(v) as count')
            ->groupBy('dateVisite')
            ->andWhere('v.dateRec >= :from')
            ->andWhere('v.dateRec <= :to')
            ->setParameters([
                'from' => $dateMin,
                'to' => $dateMax,
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(VisiteRec $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return VisiteRec[] Returns an array of VisiteRec objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VisiteRec
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
