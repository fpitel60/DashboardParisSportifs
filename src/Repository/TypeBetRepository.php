<?php

namespace App\Repository;

use App\Entity\TypeBet;
use Doctrine\ORM\Query;
use App\Entity\TypeBetSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TypeBet|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBet|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBet[]    findAll()
 * @method TypeBet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBet::class);
    }

    public function findAllVisibleQuery(TypeBetSearch $search): Query
    {
        $query = $this->findAllVisible();

        if($search->getName()) {
            $query = $query->andWhere('tb.name LIKE :name')
            ->setParameter('name', $search->getName().'%');
        }

        return $query->getQuery();
    }

    public function findAllVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('tb');
    }

    // /**
    //  * @return TypeBet[] Returns an array of TypeBet objects
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
    public function findOneBySomeField($value): ?TypeBet
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
