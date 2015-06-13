<?php 

namespace OuiEatFrench\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\AdminBundle\Entity\Season;

class LoadSeasonData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach($this->feedSeason() as $seasonName)
        {
        	$seasonAdmin = new Season();
	        $seasonAdmin->setName($seasonName);

	        $manager->persist($seasonAdmin);
        
        }
        $manager->flush();
    }

    public function feedSeason()
    {
    	return array(
    		"printemps",
            "ete",
            "automne",
            "hiver"
    		);
    }
}
