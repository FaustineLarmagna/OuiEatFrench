<?php

namespace OuiEatFrench\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CartStatus
 *
 * @ORM\Table(name="cart_status")
 * @ORM\Entity()
 */
class CartStatus
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="string", length=255)
     */
    private $translation;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\PublicBundle\Entity\Cart", mappedBy="status")
     */
    protected $carts;

    public function __construct() {
        $this->carts = new ArrayCollection();
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
     * @return CartStatus
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
     * Set translation
     *
     * @param string $translation
     * @return CartStatus
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return string 
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Add cart
     *
     * @param \OuiEatFrench\PublicBundle\Entity\Cart $cart
     *
     * @return CartStatus
     */
    public function addCart(\OuiEatFrench\PublicBundle\Entity\Cart $cart)
    {
        $this->carts[] = $cart;

        return $this;
    }

    /**
     * Remove cart
     *
     * @param \OuiEatFrench\PublicBundle\Entity\Cart $cart
     */
    public function removeCart(\OuiEatFrench\PublicBundle\Entity\Cart $cart)
    {
        $this->carts->removeElement($cart);
    }

    /**
     * Get carts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarts()
    {
        return $this->carts;
    }
}
