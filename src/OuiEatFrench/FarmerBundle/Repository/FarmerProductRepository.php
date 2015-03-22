<?php

namespace OuiEatFrench\FarmerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
* RegisterRepository
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class FarmerProductRepository extends EntityRepository
{
    public function findFarmerProductByFilters($categoryId, $companyPostCode)
    {
        $q = $this->createQueryBuilder('fp')
            ->select ('fp')
            ->join('fp.product','p')
            ->join('p.category','c')
            ->join('fp.farmer','f')
            ->where('c.id LIKE :categoryId')
            ->andWhere('f.companyPostcode LIKE :companyPostCode')
            ->setParameters(array(
                'categoryId'        => $categoryId,
                'companyPostCode'   => $companyPostCode.'%'
            ))
            ->getQuery();

        return $q->getResult();
    }
}
