<?php

namespace App\Repository;

use App\Entity\GenderSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GenderSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenderSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenderSearch[]    findAll()
 * @method GenderSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenderSearchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GenderSearch::class);
    }

    // /**
    //  * @return GenderSearch[] Returns an array of GenderSearch objects
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
    public function findOneBySomeField($value): ?GenderSearch
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
