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
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="FarmerProductCart", mappedBy="cart")
     */
    protected $farmerProductCarts;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\Command", mappedBy="cart")
     */
    protected $commands;

    /**
     * @ORM\OneToOne(targetEntity="OuiEatFrench\PaymentBundle\Entity\Order", mappedBy="cart")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    public function __construct() {
        $this->farmerProductCarts = new ArrayCollection();
        $this->commands = new ArrayCollection();
    }

    public function __toString()
    {
        return "Cart";
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Cart
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Cart
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add command
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\Command $command
     *
     * @return Cart
     */
    public function addCommand(\OuiEatFrench\FarmerBundle\Entity\Command $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Remove command
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\Command $command
     */
    public function removeCommand(\OuiEatFrench\FarmerBundle\Entity\Command $command)
    {
        $this->commands->removeElement($command);
    }

    /**
     * Get commands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Set order
     *
     * @param \OuiEatFrench\PaymentBundle\Entity\Order $order
     *
     * @return Cart
     */
    public function setOrder(\OuiEatFrench\PaymentBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \OuiEatFrench\PaymentBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
