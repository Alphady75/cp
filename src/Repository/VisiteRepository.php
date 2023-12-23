<?php

namespace App\Repository;

use App\Entity\SearchVisites;
use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Visite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visite[]    findAll()
 * @method Visite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Visite::class);

        $this->paginator = $paginator;
    }

    /**
     * Recupère les annonces en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(SearchVisites $search): PaginationInterface
    {
        $query = $this->getSearcheQuery($search)->getQuery()->getResult();


        //dd($query);

        return $this->paginator->paginate(
            $query,
            $search->page,
            99999999999
        );
    }


    /**
     * //@return QueryBuilder
     */
    private function getSearcheQuery(SearchVisites $search) //: QueryBuilder
    {
        $query = $this->createQueryBuilder('v')
            ->select('v.type as types, v.ip, COUNT(v.type) as count')
            ->orderBy('v.date', 'ASC')
            ->groupBy('types');

        if (!empty($search->getMinDate())) {
            $query = $query
                ->where('v.date >= :from')
                ->setParameter('from', $search->getMinDate());
        }

        if (!empty($search->getMaxDate())) {
            $query = $query
                ->andWhere('v.date <= :to')
                ->setParameter('to', $search->getMaxDate());
        }

        return $query;
    }

    public function findByCountByType()
    {
        return $this->createQueryBuilder('v')
            ->select('v.type as types, v.ip, COUNT(v.type) as count')
            ->orderBy('v.date', 'DESC')
            ->groupBy('types')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Visite
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countByDate()
    {
        $query = $this->createQueryBuilder('v')
            ->select('SUBSTRING(v.date, 1, 10) as dateVisite, COUNT(v) as count')
            ->groupBy('dateVisite');
        return $query->getQuery()->getResult();
    }

    public function filterByDate($dateMin, $dateMax)
    {
        return $this->createQueryBuilder('v')
            ->select('SUBSTRING(v.date, 1, 10) as dateVisite, COUNT(v) as count')
            ->groupBy('dateVisite')
            ->andWhere('v.date >= :from')
            ->andWhere('v.date <= :to')
            ->setParameters([
                'from' => $dateMin,
                'to' => $dateMax,
            ])
            ->getQuery()
            ->getResult();
    }
}
