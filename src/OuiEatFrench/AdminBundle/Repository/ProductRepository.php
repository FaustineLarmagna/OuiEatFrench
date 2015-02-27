<?php

namespace OuiEatFrench\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
* RegisterRepository
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class ProductRepository extends EntityRepository
{
    public function findAllProductBySeason($season)
    {
        $q = $this->createQueryBuilder('a')
            ->select ('a')
            ->join('a.season','u')
            ->where('u.name = :name')
            ->setParameter('name', $season)
            ->getQuery();

        return $q->getResult();
    }

    public function findAllProductByCalories($calories)
    {
        $q = $this->createQueryBuilder('a')
            ->select ('a')
            ->where('a.calories > 0')
            ->andWhere('a.calories <= :calories')
            ->setParameter('calories', $calories)
            ->getQuery();

        return $q->getResult();
    }
}
