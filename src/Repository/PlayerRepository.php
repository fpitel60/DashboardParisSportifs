<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\ORM\Query;
use App\Entity\PlayerSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function findAllVisibleQuery(PlayerSearch $search): Query
    {
        $query = $this->findAllVisible();

        if($search->getfirstName()) {
            $query = $query->andWhere('p.firstName LIKE :firstName')
            ->setParameter('firstName', $search->getFirstName().'%');
        }
        if($search->getLastName()) {
            $query = $query->andWhere('p.lastName LIKE :lastName')
            ->setParameter('lastName', $search->getLastName().'%');
        }
        if($search->getTeam()) {
            $query = $query->andWhere('p.team = :teamid')
            ->setParameter('teamid', $search->getTeam()->getId());
        }

        return $query->getQuery();
    }

    public function findAllVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    // /**
    //  * @return Player[] Returns an array of Player objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
