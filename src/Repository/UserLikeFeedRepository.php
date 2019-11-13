<?php

namespace App\Repository;

use App\Entity\UserLikeFeed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserLikeFeed|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLikeFeed|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLikeFeed[]    findAll()
 * @method UserLikeFeed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLikeFeedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserLikeFeed::class);
    }

    // /**
    //  * @return UserLikeFeed[] Returns an array of UserLikeFeed objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserLikeFeed
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
