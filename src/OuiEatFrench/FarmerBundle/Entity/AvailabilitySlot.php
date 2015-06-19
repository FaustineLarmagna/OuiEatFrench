<?php

namespace OuiEatFrench\FarmerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AvailabilitySlot
 *
 * @ORM\Table(name="availability_slot")
 * @ORM\Entity(repositoryClass="OuiEatFrench\FarmerBundle\Repository\AvailabilitySlotRepository")
 */
class AvailabilitySlot
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="machine_name", type="string", length=255, nullable=false)
     */
    private $machineName;

    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return AvailabilitySlot
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set machineName
     *
     * @param string $machineName
     * @return AvailabilitySlot
     */
    public function setMachineName($machineName)
    {
        $this->machineName = $machineName;

        return $this;
    }

    /**
     * Get machineName
     *
     * @return string
     */
    public function getMachineName()
    {
        return $this->machineName;
    }
}
