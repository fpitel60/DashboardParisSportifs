<?php

namespace App\Repository;

use App\Entity\ChoiceBet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChoiceBet|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChoiceBet|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChoiceBet[]    findAll()
 * @method ChoiceBet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChoiceBetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChoiceBet::class);
    }

    // /**
    //  * @return ChoiceBet[] Returns an array of ChoiceBet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChoiceBet
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
