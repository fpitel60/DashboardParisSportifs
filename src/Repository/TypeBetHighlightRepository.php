<?php

namespace App\Repository;

use App\Entity\Sport;
use Doctrine\ORM\QueryBuilder;
use App\Entity\TypeBetHighlight;
use Doctrine\ORM\Query\Expr\Join;
use App\Entity\TypeByBetHighlight;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TypeBetHighlight|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBetHighlight|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBetHighlight[]    findAll()
 * @method TypeBetHighlight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBetHighlightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBetHighlight::class);
    }

    // /**
    //  * @return TypeBetHighlight[] Returns an array of TypeBetHighlight objects
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
    public function findOneBySomeField($value): ?TypeBetHighlight
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
