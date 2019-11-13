<?php

namespace App\Repository;

use App\Entity\MatchProposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MatchProposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchProposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchProposition[]    findAll()
 * @method MatchProposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchPropositionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MatchProposition::class);
    }

    public function GetTargetUserPropositions($userId, $user2Id)
    {
        try {
            return $this->createQueryBuilder('mp')
                ->Where('mp.user = :user2Id')
                ->setParameter('user2Id', $user2Id)
                ->andWhere('mp.userWanted = :userId')
                ->setParameter('userId', $userId)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return $e;
        }
    }

}
