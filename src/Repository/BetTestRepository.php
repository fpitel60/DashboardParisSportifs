<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\BetTest;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method BetTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetTest[]    findAll()
 * @method BetTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetTest::class);
    }

    public function findByResultBet(User $user)
    {
        $query = $this->findAllVisible();
        
        $query = $query->orWhere('bt.resultBet = :resultBetV')
        ->setParameter('resultBetV', 'Valide')
        ->orWhere('bt.resultBet = :resultBetP')
        ->setParameter('resultBetP', 'Perdu')
        ->andWhere('bt.user = :user')
        ->setParameter('user', $user->getId());

        return $query->getQuery()->getResult();
    }

    public function findAllVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('bt');
    }

    // /**
    //  * @return BetTest[] Returns an array of BetTest objects
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
    public function findOneBySomeField($value): ?BetTest
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
