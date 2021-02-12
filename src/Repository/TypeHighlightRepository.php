<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\TypeHighlight;
use Doctrine\ORM\QueryBuilder;
use App\Entity\TypeHighlightSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TypeHighlight|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeHighlight|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeHighlight[]    findAll()
 * @method TypeHighlight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeHighlightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeHighlight::class);
    }

    public function findAllVisibleQuery(TypeHighlightSearch $search): Query
    {
        $query = $this->findAllVisible();

        if($search->getName()) {
            $query = $query->andWhere('th.name LIKE :name')
            ->setParameter('name', $search->getName().'%');
        }
        if($search->getSport()) {
            $query = $query->andWhere('th.sport = :sportid')
            ->setParameter('sportid', $search->getSport()->getId());
        }

        return $query->getQuery();
    }

    public function findAllVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('th');
    }

    // /**
    //  * @return TypeHighlight[] Returns an array of TypeHighlight objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeHighlight
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
