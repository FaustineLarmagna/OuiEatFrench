<?php

namespace OuiEatFrench\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
* RegisterRepository
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class CartRepository extends EntityRepository
{
    public function findCart($farmerId, $companyPostCode)
    {
    }
}
