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


    public function __construct() {
        $this->products = new ArrayCollection();
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
}
