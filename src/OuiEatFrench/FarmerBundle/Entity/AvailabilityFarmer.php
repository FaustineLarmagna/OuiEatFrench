<?php

namespace OuiEatFrench\FarmerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AvailabilityFarmer
 *
 * @ORM\Table(name="availability_farmer")
 * @ORM\Entity(repositoryClass="OuiEatFrench\FarmerBundle\Repository\AvailabilityFarmerRepository")
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

    /**
     * @ORM\ManyToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\AvailabilitySlot")
     */
    private $availabilitySlots;

    /**
     * @ORM\ManyToOne(targetEntity="\OuiEatFrench\FarmerBundle\Entity\UserFarmer", inversedBy="availabilityFarmers", cascade={"persist"})
     * @ORM\JoinColumn(name="farmer_id", referencedColumnName="id")
     */
    private $farmer;

    public function __construct()
    {
        $this->availabilitySlots = new ArrayCollection();
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

    /**
     * Add availabilitySlots
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\AvailabilitySlot $availabilitySlots
     * @return AvailabilityFarmer
     */
    public function addAvailabilitySlot($availabilitySlots)
    {
        $this->availabilitySlots[] = $availabilitySlots;

        return $this;
    }

    /**
     * Remove availabilitySlots
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\AvailabilitySlot $availabilitySlots
     */
    public function removeAvailabilitySlot($availabilitySlots)
    {
        $this->availabilitySlots->removeElement($availabilitySlots);
    }

    /**
     * Get availabilitySlots
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvailabilitySlots()
    {
        return $this->availabilitySlots;
    }

    /**
     * Set \OuiEatFrench\FarmerBundle\Entity\UserFarmer
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\UserFarmer $farmer
     * @return AvailabilityFarmer
     */
    public function setFarmer($farmer)
    {
        $this->farmer = $farmer;

        return $this;
    }

    /**
     * Get \OuiEatFrench\FarmerBundle\Entity\UserFarmer
     *
     * @return \OuiEatFrench\FarmerBundle\Entity\UserFarmer
     */
    public function getFarmer()
    {
        return $this->farmer;
    }
}
