<?php

namespace App\Repository;

use App\Entity\PalierMontante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PalierMontante|null find($id, $lockMode = null, $lockVersion = null)
 * @method PalierMontante|null findOneBy(array $criteria, array $orderBy = null)
 * @method PalierMontante[]    findAll()
 * @method PalierMontante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PalierMontanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PalierMontante::class);
    }

    // /**
    //  * @return PalierMontante[] Returns an array of PalierMontante objects
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
    public function findOneBySomeField($value): ?PalierMontante
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
