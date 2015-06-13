<?php 

namespace OuiEatFrench\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\AdminBundle\Entity\CommandStatus;

class LoadCommandStatusData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
        foreach($this->feedCommandStatus() as $commandStatus)
        {
            $commandStatusAdmin = new CommandStatus();
            $commandStatusAdmin->setName($commandStatus['name']);
            $commandStatusAdmin->setTranslation($commandStatus['translation']);

            $manager->persist($commandStatusAdmin);
        
        }
        $manager->flush();
    }

    public function feedCommandStatus()
    {
        return array(
            array('name' => 'paid', 'translation' => 'payée'),
            array('name' => 'ready', 'translation' => 'prête'),
            array('name' => 'closed', 'translation' => 'terminée')
        );
    }
}
