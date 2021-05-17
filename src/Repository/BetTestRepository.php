<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\BetTest;
use Doctrine\ORM\Query;
use App\Entity\Bankroll;
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

    public function findByResultBet(Bankroll $bankroll)
    {
        $query = $this->findAllVisible();
        
        $query = $query->orWhere('bt.resultBet = :resultBetV')
        ->setParameter('resultBetV', 'Valide')
        ->orWhere('bt.resultBet = :resultBetP')
        ->setParameter('resultBetP', 'Perdu')
        ->andWhere('bt.bankroll = :bankroll')
        ->setParameter('bankroll', $bankroll->getId());

        return $query->getQuery()->getResult();
    }

    public function countByDate(Bankroll $bankroll) {
        $query = $this->findAllVisible();

        $query = $query->select('COUNT(bt) as count, SUBSTRING(bt.date, 1, 10) as dateBets')
        ->orWhere('bt.resultBet = :resultBetV')
        ->setParameter('resultBetV', 'Valide')
        ->orWhere('bt.resultBet = :resultBetP')
        ->setParameter('resultBetP', 'Perdu')
        ->andWhere('bt.bankroll = :bankroll')
        ->setParameter('bankroll', $bankroll->getId())
        ->groupBy('dateBets')
        ->orderBy('dateBets', 'ASC');

        return $query->getQuery()->getResult();
    }

    public function countByDateByResult(Bankroll $bankroll, string $resultBet) {
        $query = $this->findAllVisible();

        $query = $query->select('COUNT(bt) as count, SUBSTRING(bt.date, 1, 10) as dateBets, bt.resultBet')
        ->orWhere('bt.resultBet = :resultBet')
        ->setParameter('resultBet', $resultBet)
        ->andWhere('bt.bankroll = :bankroll')
        ->setParameter('bankroll', $bankroll->getId())
        ->groupBy('dateBets')
        ->addGroupBy('bt.resultBet')
        ->orderBy('dateBets', 'ASC');

        return $query->getQuery()->getResult();
    }

    public function findBetsTestByDateByResult(Bankroll $bankroll, $date) {
        $query = $this->findAllVisible();

        $query = $query->orWhere('bt.resultBet = :resultBetV')
        ->setParameter('resultBetV', 'Valide')
        ->orWhere('bt.resultBet = :resultBetP')
        ->setParameter('resultBetP', 'Perdu')
        ->andWhere('bt.bankroll = :bankroll')
        ->setParameter('bankroll', $bankroll->getId())
        ->andWhere('SUBSTRING(bt.date, 1, 10) = :date')
        ->setParameter('date', $date);

        return $query->getQuery()->getResult();
    }

    public function findMonths(Bankroll $bankroll) {
        $query = $this->findAllVisible();

        $query = $query->select('MONTH(bt.date) AS gbMonth, YEAR(bt.date) AS gbYear')
        ->where('bt.bankroll = :bankroll')
        ->setParameter('bankroll', $bankroll->getId())
        ->groupBy('gbMonth')
        ->addGroupBy('gbYear')
        ->orderBy('bt.date', 'DESC');

        return $query->getQuery()->getResult();
    }

    public function findBetsTestByMonth($month, $year, $bankroll) {
        $query = $this->findAllVisible();

        $query = $query->select('bt.id, SUBSTRING(bt.date, 1, 10) as dateBets')
        ->where('bt.bankroll = :bankroll')
        ->setParameter('bankroll', $bankroll->getId())
        ->andWhere('SUBSTRING(bt.date, 6, 7) = :month')
        ->setParameter('month', $month)
        ->andWhere('SUBSTRING(bt.date, 1, 4) = :year')
        ->setParameter('year', $year)
        ->orderBy('bt.date', 'DESC');

        return $query->getQuery()->getResult();
    }

    public function findWeeks(Bankroll $bankroll) {
        $query = $this->findAllVisible();

        $query = $query->select('bt.week')
        ->where('bt.bankroll = :bankroll')
        ->setParameter('bankroll', $bankroll->getId())
        ->groupBy('bt.week')
        ->orderBy('bt.week', 'DESC');

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
