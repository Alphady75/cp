<?php

namespace App\Repository;

use App\Entity\Convertis;
use App\Entity\SearchConvertis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Convertis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Convertis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Convertis[]    findAll()
 * @method Convertis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConvertisRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Convertis::class);

        $this->paginator = $paginator;
    }

    /**
     * Recupère les annonces en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(SearchConvertis $search): PaginationInterface
    {
        $query = $this->getSearcheQuery($search)->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            20
        );
    }

    /**
     * //@return QueryBuilder
     */
    private function getSearcheQuery(SearchConvertis $search) //: QueryBuilder
    {
        $query = $this->createQueryBuilder('c')
            ->select('r', 'c')
            ->leftjoin('c.recurrences', 'r')
            ->orderBy('c.created', 'DESC');

        if (!empty($search->getInstagram())) {
            $query = $query
                ->andWhere('c.instagram LIKE :instagram')
                ->orWhere('c.numero LIKE :numero')
                ->setParameters([
                    'instagram' => "%{$search->getInstagram()}%",
                    'numero' => "%{$search->getInstagram()}%",
                ]);
        }

        if (!empty($search->getMinDate())) {
            $query = $query
                ->andWhere('c.created >= :from')
                ->setParameter('from', $search->getMinDate());
        }

        if (!empty($search->getMaxDate())) {
            $query = $query
                ->andWhere('c.created <= :to')
                ->setParameter('to', $search->getMaxDate());
        }

        if ($search->getListeAttente() == false) {
            $query = $query
                ->andWhere('c.listeAttente = :listeAttente')
                ->setParameter('listeAttente', false);
        }

        if ($search->getListeAttente() == true) {
            $query = $query
                ->andWhere('c.listeAttente = :listeAttente')
                ->setParameter('listeAttente', true);
        }

        return $query;
    }

    public function countByDate(){
        $query = $this->createQueryBuilder('c')
            ->select('SUBSTRING(c.created, 1, 10) as dateConv, COUNT(c) as count')
            ->groupBy('dateConv')
        ;
        return $query->getQuery()->getResult();

        /*$query = $this->getEntityManager()->createQuery("
            SELECT SUBSTRING(a.created_at, 1, 10) as dateAnnonces, COUNT(a) as count FROM App\Entity\Annonces a GROUP BY dateAnnonces
        ");
        return $query->getResult();*/
    }

    public function countByDateListeAttente($listeAttente, $from = null, $to = null){
        $query = $this->createQueryBuilder('c')
            ->select('SUBSTRING(c.created, 1, 10) as dateConv, COUNT(c) as count')
            ->groupBy('dateConv')
            ->andWhere('c.listeAttente = :listeAttente')
            ->setParameter('listeAttente', $listeAttente)
        ;

        if (!empty($from)) {
            $query = $query
                ->andWhere('c.created >= :from')
                ->setParameter('from', $from);
        }

        if (!empty($to)) {
            $query = $query
                ->andWhere('c.created >= :to')
                ->setParameter('to', $to);
        }

        return $query->getQuery()->getResult();

        /*$query = $this->getEntityManager()->createQuery("
            SELECT SUBSTRING(a.created_at, 1, 10) as dateAnnonces, COUNT(a) as count FROM App\Entity\Annonces a GROUP BY dateAnnonces
        ");
        return $query->getResult();*/
    }

    public function filterByDate($dateMin = null, $dateMax = null)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.created >= :from')
            ->andWhere('v.created <= :to')
            ->setParameters([
                'from' => $dateMin,
                'to' => $dateMax,
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterByDateListeAttente($dateMin, $dateMax)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.created >= :from')
            ->andWhere('c.created <= :to')
            ->andWhere('c.listeAttente = :listeAttente')
            ->setParameters([
                'from' => $dateMin,
                'to' => $dateMax,
                'listeAttente' => true,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
