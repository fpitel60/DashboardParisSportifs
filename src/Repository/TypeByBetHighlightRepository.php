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
 * @method TypeByBetHighlight|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeByBetHighlight|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeByBetHighlight[]    findAll()
 * @method TypeByBetHighlight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeByBetHighlightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeByBetHighlight::class);
    }

    public function findBySport(Sport $sport)
    {
        $query = $this->findAllVisible();

        $query = $query->innerJoin(
            TypeBetHighlight::class,
            'tbh',
            Join::WITH,
            'tbbh.typeBetHighlight = tbh.id'
        )
        ->where('tbh.sport = :sport')
        ->setParameter('sport', $sport->getId());

        return $query->getQuery()->getResult();
    }

    public function findAllVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('tbbh');
    }

    // /**
    //  * @return TypeByBetHighlight[] Returns an array of TypeByBetHighlight objects
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
    public function findOneBySomeField($value): ?TypeByBetHighlight
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
