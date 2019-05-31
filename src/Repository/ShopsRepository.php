<?php

namespace App\Repository;

use App\Entity\Shops;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr;


/**
 * @method Shops|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shops|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shops[]    findAll()
 * @method Shops[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Shops::class);
    }

    public function findAllShopNearByQuery() : Query
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.distance', 'ASC')
            ->getQuery();
    }

    /**
     * find All Shop NearBy Without the one that are Liked or (the Disleked one that happen before 2 hours)
     * @return Query
     */
    public function findAllShopNearByWLADQuery() : Query
    {
        //$query = "SELECT s.id,s.distance FROM App\Entity\Shops s LEFT JOIN s.preferredShops p WHERE p.id is null OR (p.opinion = 2 and p.updated_at <= DATE_SUB(NOW(),INTERVAL 2 HOUR) ) ORDER BY s.distance ASC";

        $qb  = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('App\Entity\Shops', 's')
            ->leftJoin('s.preferredShops', 'p')
            ->where('p.id is null')
            ->orWhere('(p.opinion = 2  and p.updatedAt <= :date)')
            ->setParameter('date', new \DateTime('-2 hours'))
            ->orderBy('s.distance', 'ASC');

        return $qb->getQuery();
    }


    /**
     * @return Query
     */
    public function findAllPreferredShopQuery($id): Query
    {
        $qb  = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('App\Entity\Shops', 's')
            ->leftJoin('s.preferredShops', 'p')
            ->where('p.id is not null and p.opinion = 1 and p.user = :userId')
            ->setParameter('userId', $id)
            ->orderBy('s.distance', 'ASC');

        return $qb->getQuery();
    }
}
