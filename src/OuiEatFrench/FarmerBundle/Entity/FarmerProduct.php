<?php

namespace OuiEatFrench\FarmerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Farmer-Product
 *
 * @ORM\Table(name="farmer_product")
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
    private $id;

    // /**
    //  * @var integer
    //  *
    //  * @Assert\NotBlank()
    //  * @ORM\Column(name="farmer_id", type="integer")
    //  */
    // private $idFarmer;

    // /**
    //  * @var integer
    //  *
    //  * @Assert\NotBlank()
    //  * @ORM\Column(name="product_id", type="integer")
    //  */
    // private $idProduct;

    /** 
     * @ORM\ManyToOne(targetEntity="\OuiEatFrench\AdminBundle\Entity\Product", inversedBy="farmerProducts")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;
    

    /** 
     * @ORM\ManyToOne(targetEntity="\OuiEatFrench\FarmerBundle\Entity\UserFarmer", inversedBy="farmerProducts")
     * @ORM\JoinColumn(name="farmer_id", referencedColumnName="id")
     */
    private $farmer;

    /**
     * @var boolean
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="selling", type="boolean")
     */
    private $selling = false;

    /**
     * Like "kg", "barquette", "pièce", "filet"
     *
     * @ORM\ManyToOne(targetEntity="\OuiEatFrench\AdminBundle\Entity\UnitType", inversedBy="farmerProducts")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     */
    private $unitType;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="unit_price", type="integer")
     */
    private $unitPrice;

    /**
     * Stock to sell
     *
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="unit_quantity", type="integer")
     */
    private $unitQuantity;

    /**
     * Stock minimum before removing from sell
     *
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="unit_minimum", type="integer")
     */
    private $unitMinimum;

    /**
     * Like "conventionnelle" "précision" "raisonnée" "intégrée" "durable" "multifonctionnelle" "biologique"
     *
     * @ORM\ManyToOne(targetEntity="\OuiEatFrench\AdminBundle\Entity\AgricultureType", inversedBy="farmerProducts")
     * @ORM\JoinColumn(name="agriculture_id", referencedColumnName="id")
     */
    private $agricultureType;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="conservation", type="text")
     */
    private $conservation;


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
     * Set \OuiEatFrench\AdminBundle\Entity\Product
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Product $product
     * @return FarmerProduct
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get \OuiEatFrench\AdminBundle\Entity\Product
     *
     * @return \OuiEatFrench\AdminBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set \OuiEatFrench\FarmerBundle\Entity\UserFarmer
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\UserFarmer $farmer
     * @return FarmerProduct
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

    /**
     * Set selling
     *
     * @param boolean $selling
     * @return FarmerProduct
     */
    public function setSelling($selling)
    {
        $this->selling = $selling;
        return $this;
    }

    /**
     * Get selling
     *
     * @return integer
     */
    public function getSelling()
    {
        return $this->selling;
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
     * Set \OuiEatFrench\AdminBundle\Entity\UnitType
     *
     * @param \OuiEatFrench\AdminBundle\Entity\UnitType $unitType
     * @return FarmerProduct
     */
    public function setUnitType($unitType)
    {
        $this->unitType = $unitType;
        return $this;
    }

    /**
     * Get \OuiEatFrench\AdminBundle\Entity\UnitType
     *
     * @return \OuiEatFrench\AdminBundle\Entity\UnitType
     */
    public function getUnitType()
    {
        return $this->unitType;
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
     * Set unitMinimum
     *
     * @param integer $unitMinimum
     * @return FarmerProduct
     */
    public function setUnitMinimum($unitMinimum)
    {
        $this->unitMinimum = $unitMinimum;
        return $this;
    }

    /**
     * Get unitQuantity
     *
     * @return integer
     */
    public function getUnitMinimum()
    {
        return $this->unitMinimum;
    }

    /**
     * Set \OuiEatFrench\AdminBundle\Entity\AgricultureType
     *
     * @param \OuiEatFrench\AdminBundle\Entity\AgricultureType $agricultureType
     * @return FarmerProduct
     */
    public function setAgricultureType($agricultureType)
    {
        $this->agricultureType = $agricultureType;
        return $this;
    }

    /**
     * Get \OuiEatFrench\AdminBundle\Entity\AgricultureType
     *
     * @return \OuiEatFrench\AdminBundle\Entity\AgricultureType
     */
    public function getAgricultureType()
    {
        return $this->agricultureType;
    }

    /**
     * Set conservation
     *
     * @param string $conservation
     * @return FarmerProduct
     */
    public function setConservation($conservation)
    {
        $this->conservation = $conservation;
        return $this;
    }

    /**
     * Get conservation
     *
     * @return string
     */
    public function getConservation()
    {
        return $this->conservation;
    }
}
