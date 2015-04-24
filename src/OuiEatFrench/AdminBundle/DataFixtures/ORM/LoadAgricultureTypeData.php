<?php 

namespace OuiEatFrench\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\AdminBundle\Entity\AgricultureType;

class LoadAgricultureTypeData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
        foreach($this->feedAgricultureType() as $agricultureTypeName)
        {
        	$agricultureTypeAdmin = new AgricultureType();
	        $agricultureTypeAdmin->setName($agricultureTypeName);

	        $manager->persist($agricultureTypeAdmin);
        
        }
        $manager->flush();
    }

    public function feedAgricultureType()
    {
    	return array(
            "conventionnelle",
            "précision",
            "raisonnée",
            "intégrée",
            "durable",
            "multifonctionnelle",
            "biologique"
    		);
    }
}