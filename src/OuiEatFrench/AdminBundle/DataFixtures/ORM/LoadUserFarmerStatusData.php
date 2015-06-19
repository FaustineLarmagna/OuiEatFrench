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
        
        foreach($this->feedUserFarmerStatus() as $userFarmerStatus)
        {
        	$userFarmerStatusAdmin = new UserFarmerStatus();
	        $userFarmerStatusAdmin->setName($userFarmerStatus['name']);
            $userFarmerStatusAdmin->setColor($userFarmerStatus['color']);
            $userFarmerStatusAdmin->setTranslation($userFarmerStatus['translation']);

	        $manager->persist($userFarmerStatusAdmin);
        
        }
        $manager->flush();
    }

    public function feedUserFarmerStatus()
    {
    	return array(
            array('name' => 'to_review', 'color' => '#C6C6C6', 'translation' => 'Candidature à traiter'),
            array('name' => 'missing_information', 'color' => '#E65353', 'translation' => 'Manque un document'),
            array('name' => 'validate', 'color' => '#C2E36F', 'translation' => 'Valider la candidature'),
            array('name' => 'banned', 'color' => '#5C5C5C', 'translation' => 'Bannir le producteur'),
            array('name' => 'in_progress', 'color' => '#9AD0E6', 'translation' => 'En cours')
    	);
    }
}