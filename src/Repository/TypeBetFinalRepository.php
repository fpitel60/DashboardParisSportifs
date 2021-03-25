<?php

namespace App\Repository;

use App\Entity\TypeBetFinal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeBetFinal|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBetFinal|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBetFinal[]    findAll()
 * @method TypeBetFinal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBetFinalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBetFinal::class);
    }

    // /**
    //  * @return TypeBetFinal[] Returns an array of TypeBetFinal objects
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
    public function findOneBySomeField($value): ?TypeBetFinal
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
