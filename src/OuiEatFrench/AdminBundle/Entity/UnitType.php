<?php

namespace OuiEatFrench\AdminBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UnitType
 *
 * @ORM\Table(name="unit_type")
 * @ORM\Entity()
 */
class UnitType
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\AdminBundle\Entity\Product", mappedBy="unitType")
     */
    protected $products;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\FarmerProductClone", mappedBy="unitType")
     */
    protected $farmerProductClones;


    public function __construct() {
        $this->farmerProduct = new ArrayCollection();
        $this->farmerProductClones = new ArrayCollection();
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
     * @return UnitType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return integer
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add product
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Product $product
     *
     * @return UnitType
     */
    public function addProduct($product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Product $product
     */
    public function removeProduct($product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get Products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add farmerProductClone
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\FarmerProductClone $farmerProductClone
     *
     * @return UnitType
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
