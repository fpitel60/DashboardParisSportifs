<?php

namespace App\Repository;

use App\Entity\TypeBetGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeBetGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBetGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBetGame[]    findAll()
 * @method TypeBetGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBetGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBetGame::class);
    }

    // /**
    //  * @return TypeBetGame[] Returns an array of TypeBetGame objects
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
    public function findOneBySomeField($value): ?TypeBetGame
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
