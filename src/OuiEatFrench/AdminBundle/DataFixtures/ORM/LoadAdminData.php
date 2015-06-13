<?php 

namespace OuiEatFrench\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\AdminBundle\Entity\User;

class LoadAdminData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach($this->feedAdmin() as $admin)
        {
        	$userAdmin = new User();
	        $userAdmin->setUsername($admin['username']);
            $userAdmin->setEmail($admin['email']);
            $userAdmin->setPassword($admin['password']);

	        $manager->persist($userAdmin);
        }

        $manager->flush();
    }

    public function feedAdmin()
    {
    	return array(
    	   array('username' => 'guillaume', 'email' => 'guillaume.flambard01@gmail.com', 'password' => 'password'),
           array('username' => 'bastien', 'email' => 'basthenry@gmail.com', 'password' => 'password'),
           array('username' => 'faustine', 'email' => 'f.larmagna@gmail.com', 'password' => 'password')
    	);
    }
}
