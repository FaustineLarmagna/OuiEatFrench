<?php

namespace OuiEatFrench\AdminBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AgricultureType
 *
 * @ORM\Table(name="agriculture_type")
 * @ORM\Entity()
 */
class AgricultureType
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\FarmerProduct", mappedBy="agricultureType")
     */
    protected $farmerProducts;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\FarmerProductClone", mappedBy="agricultureType")
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
     * @return AgricultureType
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
     * Add farmerProduct
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\FarmerProduct $farmerProduct
     *
     * @return AgricultureType
     */
    public function addFarmerProduct(\OuiEatFrench\FarmerBundle\Entity\FarmerProduct $farmerProduct)
    {
        $this->farmerProducts[] = $farmerProduct;

        return $this;
    }

    /**
     * Remove farmerProduct
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\FarmerProduct $farmerProduct
     */
    public function removeFarmerProduct(\OuiEatFrench\FarmerBundle\Entity\FarmerProduct $farmerProduct)
    {
        $this->farmerProducts->removeElement($farmerProduct);
    }

    /**
     * Get farmerProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFarmerProducts()
    {
        return $this->farmerProducts;
    }

    /**
     * Add farmerProductClone
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\FarmerProductClone $farmerProductClone
     *
     * @return AgricultureType
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
