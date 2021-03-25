<?php

namespace App\Repository;

use App\Entity\Bankroll;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bankroll|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bankroll|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bankroll[]    findAll()
 * @method Bankroll[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankrollRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bankroll::class);
    }

    // /**
    //  * @return Bankroll[] Returns an array of Bankroll objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bankroll
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
