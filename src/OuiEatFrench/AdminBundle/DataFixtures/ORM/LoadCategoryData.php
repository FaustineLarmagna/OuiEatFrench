<?php 

namespace OuiEatFrench\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OuiEatFrench\AdminBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach($this->feedCategories() as $categoryName)
        {
        	$categoryAdmin = new Category();
	        $categoryAdmin->setName($categoryName);

	        $manager->persist($categoryAdmin);
        
        }
        $manager->flush();
    }

    public function feedCategories()
    {
    	return array(
    		"fruits",
    		"legumes",
    		"autres",
    		);
    }
}