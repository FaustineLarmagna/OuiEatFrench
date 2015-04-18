<?php

namespace OuiEatFrench\FarmerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserFarmer
 *
 * @ORM\Table(name="availability_farmer")
 * @ORM\Entity(repositoryClass="OuiEatFrench\FarmerBundle\Repository\UserFarmerRepository")
 */
class AvailabilityFarmer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
    }

    public function __toString()
    {
        return "";
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
