<?php

namespace OuiEatFrench\PublicBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="OuiEatFrench\PublicBundle\Repository\CartRepository")
 */
class Cart
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
     * @ORM\ManyToOne(targetEntity="OuiEatFrench\UserBundle\Entity\User", inversedBy="carts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="OuiEatFrench\AdminBundle\Entity\CartStatus", inversedBy="carts")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="FarmerProductCart", mappedBy="cart")
     */
    protected $farmerProductCarts;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\Command", mappedBy="cart")
     */
    protected $command;

    public function __construct() {
        $this->farmerProductCarts = new ArrayCollection();
        $this->command = new ArrayCollection();
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
     * Set user
     *
     * @param string $user
     * @return Cart
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Cart
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add farmerProductCarts
     *
     * @param \OuiEatFrench\PublicBundle\Entity\FarmerProductCart $farmerProductCarts
     * @return Cart
     */
    public function addFarmerProductCart(\OuiEatFrench\PublicBundle\Entity\FarmerProductCart $farmerProductCarts)
    {
        $this->farmerProductCarts[] = $farmerProductCarts;

        return $this;
    }

    /**
     * Remove farmerProductCarts
     *
     * @param \OuiEatFrench\PublicBundle\Entity\FarmerProductCart $farmerProductCarts
     */
    public function removeFarmerProductCart(\OuiEatFrench\PublicBundle\Entity\FarmerProductCart $farmerProductCarts)
    {
        $this->farmerProductCarts->removeElement($farmerProductCarts);
    }

    /**
     * Get farmerProductCarts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFarmerProductCarts()
    {
        return $this->farmerProductCarts;
    }
}
