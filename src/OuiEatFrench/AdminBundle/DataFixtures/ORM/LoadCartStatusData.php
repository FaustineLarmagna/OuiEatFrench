<?php 

namespace OuiEatFrench\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\AdminBundle\Entity\CartStatus;

class LoadCartStatusData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
        foreach($this->feedCartStatus() as $cartStatus)
        {
        	$cartStatusAdmin = new CartStatus();
            $cartStatusAdmin->setName($cartStatus['name']);
            $cartStatusAdmin->setTranslation($cartStatus['translation']);

	        $manager->persist($cartStatusAdmin);
        
        }
        $manager->flush();
    }

    public function feedCartStatus()
    {
    	return array(
            array('name' => 'in_progress', 'translation' => 'en cours'),
            array('name' => 'paid', 'translation' => 'payé')
    	);
    }
}