<?php 

namespace OuiEatFrench\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\AdminBundle\Entity\UnitType;

class LoadUnitTypeData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
        foreach($this->feedUnitType() as $unitTypeName)
        {
        	$unitTypeAdmin = new UnitType();
	        $unitTypeAdmin->setName($unitTypeName);

	        $manager->persist($unitTypeAdmin);
        
        }
        $manager->flush();
    }

    public function feedUnitType()
    {
    	return array(
            "kg",
            "barquette(s)",
            "filet(s)",
            "pièce(s)",
            "panier(s)"
    		);
    }
}