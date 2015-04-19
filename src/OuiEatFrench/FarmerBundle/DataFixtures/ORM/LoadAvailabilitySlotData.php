<?php 

namespace OuiEatFrench\FarmerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\FarmerBundle\Entity\AvailabilitySlot;

class LoadAvailabilitySlotData implements FixtureInterface
{
    // php app/console doctrine:fixtures:load --fixtures=src/OuiEatFrench/FarmerBundle/DataFixtures/ORM/ --append

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach($this->feedAvailabilitySlots() as $categoryName)
        {
        	$categoryAdmin = new AvailabilitySlot();
	        $categoryAdmin->setName($categoryName);

	        $manager->persist($categoryAdmin);
        
        }
        $manager->flush();
    }

    public function feedAvailabilitySlots()
    {
    	return array(
    		"lundi matin",
    		"lundi après-midi",
    		"mardi matin",
    		"mardi après-midi",
    		"mercredi matin",
    		"mercredi après-midi",
    		"jeudi matin",
    		"jeudi après-midi",
    		"vendredi matin",
    		"vendredi après-midi",
    		"samedi matin",
    		"samedi après-midi",
    		"dimanche matin",
    		"dimanche après-midi",
    		);
    }
}
