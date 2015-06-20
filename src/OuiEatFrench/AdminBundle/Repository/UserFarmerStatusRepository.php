<?php

namespace OuiEatFrench\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use OuiEatFrench\AdminBundle\Entity\UserFarmerStatus;

class UserFarmerStatusRepository extends EntityRepository
{
	public function findButtonStatus() {
		$q = $this->createQueryBuilder('s')
            ->select ('s')
            ->where('s.id IN (2, 3, 4)')
            ->getQuery();

        return $q->getResult();
	}
}
