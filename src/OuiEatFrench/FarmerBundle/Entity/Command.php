<?php

namespace OuiEatFrench\FarmerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Command
 *
 * @ORM\Table(name="command")
 * @ORM\Entity(repositoryClass="OuiEatFrench\FarmerBundle\Repository\CommandRepository")
 */
class Command
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
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="OuiEatFrench\PublicBundle\Entity\Cart", inversedBy="command")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    private $cart;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="UserFarmer", inversedBy="commands")
     * @ORM\JoinColumn(name="farmer_id", referencedColumnName="id")
     */
    private $farmer;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="OuiEatFrench\AdminBundle\Entity\CommandStatus", inversedBy="commands")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\FarmerProductClone", mappedBy="command")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $farmerProductClones;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->farmerProductClones = new ArrayCollection();
    }

    public function __toString()
    {
        return "Command";
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
     * Set cart
     *
     * @param \OuiEatFrench\PublicBundle\Entity\Cart $cart
     * @return Command
     */
    public function setCart(\OuiEatFrench\PublicBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \OuiEatFrench\PublicBundle\Entity\Cart 
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set farmer
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\UserFarmer $farmer
     * @return Command
     */
    public function setFarmer(\OuiEatFrench\FarmerBundle\Entity\UserFarmer $farmer = null)
    {
        $this->farmer = $farmer;

        return $this;
    }

    /**
     * Get farmer
     *
     * @return \OuiEatFrench\FarmerBundle\Entity\UserFarmer 
     */
    public function getFarmer()
    {
        return $this->farmer;
    }

    /**
     * Set status
     *
     * @param \OuiEatFrench\AdminBundle\Entity\CommandStatus $status
     * @return Command
     */
    public function setStatus(\OuiEatFrench\AdminBundle\Entity\CommandStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \OuiEatFrench\AdminBundle\Entity\CommandStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add farmerProductClone
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\FarmerProductClone $farmerProductClone
     *
     * @return Command
     */
    public function addFarmerProductClone(\OuiEatFrench\FarmerBundle\Entity\FarmerProductClone $farmerProductClone)
    {
        $this->farmerProductClones[] = $farmerProductClone;

        return $this;
    }

    /**
     * Remove farmerProductClone
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\FarmerProductClone $farmerProductClone
     */
    public function removeFarmerProductClone(\OuiEatFrench\FarmerBundle\Entity\FarmerProductClone $farmerProductClone)
    {
        $this->farmerProductClones->removeElement($farmerProductClone);
    }

    /**
     * Get farmerProductClones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFarmerProductClones()
    {
        return $this->farmerProductClones;
    }
}
