<?php

namespace OuiEatFrench\PublicBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProductCart
 *
 * @ORM\Table(name="farmer_product_cart")
 * @ORM\Entity
 */
class FarmerProductCart
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
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="farmerProductCarts")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $cart;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="OuiEatFrench\FarmerBundle\Entity\FarmerProduct", inversedBy="farmerProductCarts")
     * @ORM\JoinColumn(name="farmer_product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $farmerProduct;

    /**
     * @var integer
     *
     * @ORM\Column(name="unitQuantity", type="float")
     */
    private $unitQuantity;


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
     * @param string $cart
     * @return ProductCart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return string 
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set farmerProduct
     *
     * @param string $farmerProduct
     * @return ProductCart
     */
    public function setFarmerProduct($farmerProduct)
    {
        $this->farmerProduct = $farmerProduct;

        return $this;
    }

    /**
     * Get farmerProduct
     *
     * @return string 
     */
    public function getFarmerProduct()
    {
        return $this->farmerProduct;
    }

    /**
     * Set unitQuantity
     *
     * @param integer $unitQuantity
     * @return ProductCart
     */
    public function setUnitQuantity($unitQuantity)
    {
        $this->unitQuantity = $unitQuantity;

        return $this;
    }

    /**
     * Get unitQuantity
     *
     * @return integer 
     */
    public function getUnitQuantity()
    {
        return $this->unitQuantity;
    }
}
