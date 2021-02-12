<?php

namespace App\Repository;

use App\Entity\GameTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameTest[]    findAll()
 * @method GameTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameTest::class);
    }

    // /**
    //  * @return GameTest[] Returns an array of GameTest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameTest
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
