<?php

namespace App\Repository;

use App\Entity\FeedComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FeedComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeedComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedComment[]    findAll()
 * @method FeedComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FeedComment::class);
    }

    // /**
    //  * @return FeedComment[] Returns an array of FeedComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FeedComment
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
