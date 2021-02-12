<?php

namespace App\Repository;

use App\Entity\League;
use Doctrine\ORM\Query;
use App\Entity\LeagueSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method League|null find($id, $lockMode = null, $lockVersion = null)
 * @method League|null findOneBy(array $criteria, array $orderBy = null)
 * @method League[]    findAll()
 * @method League[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeagueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, League::class);
    }

    public function findAllVisibleQuery(LeagueSearch $search): Query
    {
        $query = $this->findAllVisible();

        if($search->getName()) {
            $query = $query->andWhere('l.name LIKE :name')
            ->setParameter('name', $search->getName().'%');
        }
        if($search->getSport()) {
            $query = $query->andWhere('l.sport = :sportid')
            ->setParameter('sportid', $search->getSport()->getId());
        }
        if($search->getCountry()) {
            $query = $query->andWhere('l.country = :countryid')
            ->setParameter('countryid', $search->getCountry()->getId());
        }

        return $query->getQuery();
    }

    public function findAllVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('l');
    }

    // /**
    //  * @return League[] Returns an array of League objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?League
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
