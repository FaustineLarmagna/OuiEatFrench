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
    public function findFarmerProductByFilters($productId, $companyPostCode)
    {
        $q = $this->createQueryBuilder('fp')
            ->select ('fp')
            ->join('fp.product','p')
            ->join('fp.farmer','f')
            ->where('p.id LIKE :productId')
            ->andWhere('f.companyPostcode LIKE :companyPostCode')
            ->setParameters(array(
                'productId'        => $productId,
                'companyPostCode'   => $companyPostCode.'%'
            ))
            ->getQuery();

        return $q->getResult();
    }
}
