<?php 

namespace OuiEatFrench\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\AdminBundle\Entity\UserFarmerStatus;

class LoadUserFarmerStatusData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
        foreach($this->feedUserFarmerStatus() as $userFarmerStatusName)
        {
        	$userFarmerStatusAdmin = new UserFarmerStatus();
	        $userFarmerStatusAdmin->setName($userFarmerStatusName);

	        $manager->persist($userFarmerStatusAdmin);
        
        }
        $manager->flush();
    }

    public function feedUserFarmerStatus()
    {
    	return array(
            "to_review",
            "missing_information",
            "validate",
            "banned",
            "in_progress"
    		);
    }
}