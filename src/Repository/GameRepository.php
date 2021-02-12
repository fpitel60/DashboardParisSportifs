<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\ORM\Query;
use App\Entity\GameSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findBySport(PersistentCollection $leagues)
    {
        $query = $this->findAllVisible();

        $i = 0;
        foreach($leagues as $league)
        {
            $query = $query->orWhere('g.league = :league'.$i)
            ->setParameter('league'.$i, $league->getId());
            $i++;
        }

        return $query->getQuery();
    }

    public function findByLeague($leagueid)
    {
        $query = $this->findAllVisible();

        $query = $query->Where('g.league = :league')
        ->setParameter('league', $leagueid);

        return $query->getQuery();
    }

    public function findAllVisibleQuery(GameSearch $search): Query
    {
        $query = $this->findAllVisible();

        if($search->getDate()) {
            $query = $query->andWhere('g.date LIKE :date')
            ->setParameter('date', $search->getDate());
        }
        if($search->getHomeTeam()) {
            $query = $query->andWhere('g.homeTeam = :homeTeamId')
            ->setParameter('homeTeamId', $search->getHomeTeam()->getId());
        }
        if($search->getForeignTeam()) {
            $query = $query->andWhere('g.foreignTeam = :foreignTeamId')
            ->setParameter('foreignTeamId', $search->getForeignTeam()->getId());
        }

        return $query->getQuery();
    }

    public function findAllVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('g');
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
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
    public function findOneBySomeField($value): ?Game
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
