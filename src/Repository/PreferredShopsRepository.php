<?php

namespace App\Repository;

use App\Entity\PreferredShops;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PreferredShops|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreferredShops|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreferredShops[]    findAll()
 * @method PreferredShops[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreferredShopsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PreferredShops::class);
    }

    // /**
    //  * @return PreferredShops[] Returns an array of PreferredShops objects
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
    public function findOneBySomeField($value): ?PreferredShops
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
