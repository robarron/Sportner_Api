<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function getUserConversation($userId, $receptorId)
    {
        $qb = $this->createQueryBuilder('m');

        return $qb
            ->andWhere($qb->expr()->andX(
                $qb->expr()->eq('m.sender', $userId),
                $qb->expr()->eq('m.receptor', $receptorId)
            ))
            ->orWhere($qb->expr()->andX(
                $qb->expr()->eq('m.sender', $receptorId),
                $qb->expr()->eq('m.receptor', $userId)
            ))
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getUserLastMessage($userId, $receptorId)
    {
        $qb = $this->createQueryBuilder('m');

        return $qb
            ->andWhere($qb->expr()->andX(
                $qb->expr()->eq('m.sender', $userId),
                $qb->expr()->eq('m.receptor', $receptorId)
            ))
            ->orWhere($qb->expr()->andX(
                $qb->expr()->eq('m.sender', $receptorId),
                $qb->expr()->eq('m.receptor', $userId)
            ))
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }
    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
