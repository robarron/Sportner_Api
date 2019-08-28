<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function FindAllImagesExceptMe($userId, $userMatchIds)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.user != :userId')
            ->andWhere('i.user NOT IN (:userMatchIds)')
            ->setParameter('userId', $userId)
            ->setParameter('userMatchIds', sizeof($userMatchIds) > 0 ? $userMatchIds : 0)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getUserProfilPicture($userId)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.user = :userId')
            ->andWhere('i.profilPic is not null')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
            ;
    }
}
