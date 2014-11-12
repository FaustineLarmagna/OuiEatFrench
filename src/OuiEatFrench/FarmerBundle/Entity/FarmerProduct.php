<?php

namespace OuiEatFrench\FarmerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Farmers-Products
 *
 * @ORM\Table(name="farmers_products")
 * @ORM\Entity()
 */
class FarmerProduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="id_farmer", type="integer")
     */
    protected $idFarmer;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="id_product", type="integer")
     */
    protected $idProduct;

    /** IN FARMER ENTITY
     *
     * @ORM\OneToMany(targetEntity="FarmerProduct", mappedBy="idFarmer")
     */
    /*
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    */

    /** IN PRODUCT ENTITY
     *
     * @ORM\OneToMany(targetEntity="FarmerProduct", mappedBy="idProduct")
     */
    /*
    protected $farmers;

    public function __construct()
    {
        $this->farmers = new ArrayCollection();
    }
    */

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="unit_price", type="integer")
     */
    protected $unitPrice;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="kilo_price", type="integer")
     */
    protected $kiloPrice;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="unit_quantity", type="integer")
     */
    protected $unitQuantity;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="kilo_quantity", type="integer")
     */
    protected $kiloQuantity;


    public function __toString()
    {
        return "FarmerProduct";
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
     * Set idFarmer
     *
     * @param integer $idFarmer
     * @return FarmerProduct
     */
    public function setIdFarmer($idFarmer)
    {
        $this->idFarmer = $idFarmer;

        return $this;
    }

    /**
     * Get idFarmer
     *
     * @return integer
     */
    public function getIdFarmer()
    {
        return $this->idFarmer;
    }

    /**
     * Set idProduct
     *
     * @param integer $idProduct
     * @return FarmerProduct
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get idProduct
     *
     * @return integer
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set unitPrice
     *
     * @param integer $unitPrice
     * @return FarmerProduct
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return integer
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set kiloPrice
     *
     * @param integer $kiloPrice
     * @return FarmerProduct
     */
    public function setKiloPrice($kiloPrice)
    {
        $this->kiloPrice = $kiloPrice;
        return $this;
    }

    /**
     * Get kiloPrice
     *
     * @return integer
     */
    public function getKiloPrice()
    {
        return $this->kiloPrice;
    }

    /**
     * Set unitQuantity
     *
     * @param integer $unitQuantity
     * @return FarmerProduct
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

    /**
     * Set kiloQuantity
     *
     * @param integer $kiloQuantity
     * @return FarmerProduct
     */
    public function setKiloQuantity($kiloQuantity)
    {
        $this->kiloQuantity = $kiloQuantity;
        return $this;
    }

    /**
     * Get kiloQuantity
     *
     * @return integer
     */
    public function getKiloQuantity()
    {
        return $this->kiloQuantity;
    }
}
