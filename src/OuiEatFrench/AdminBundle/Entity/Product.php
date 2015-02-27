<?php

namespace OuiEatFrench\AdminBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * AdminList
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="OuiEatFrench\AdminBundle\Repository\ProductRepository")
 */
class Product
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
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="string", length=100)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="text", length=255, nullable=true)
     */
    protected $imageName;

    protected $image;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="calories", type="integer", length=100)
     */
    protected $calories;

    /**
     * @ORM\ManyToMany(targetEntity="Filter")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $filter;

    /**
     * @ORM\ManyToMany(targetEntity="Season")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="parent_product_id", referencedColumnName="id")
     */
    private $parentProduct;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\FarmerProduct", mappedBy="product")
     */
    protected $farmerProducts;


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
     * @return Product
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
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Product
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\OuiEatFrench\AdminBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \OuiEatFrench\AdminBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->farmerProducts = new ArrayCollection();
        $this->filter = new ArrayCollection();
        $this->season = new ArrayCollection();
    }

    /**
     * Add filter
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Filter $filter
     * @return Product
     */
    public function addFilter(\OuiEatFrench\AdminBundle\Entity\Filter $filter)
    {
        $this->filter[] = $filter;

        return $this;
    }

    /**
     * Remove filter
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Filter $filter
     */
    public function removeFilter(\OuiEatFrench\AdminBundle\Entity\Filter $filter)
    {
        $this->filter->removeElement($filter);
    }

    /**
     * Get filter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set calories
     *
     * @param string $calories
     * @return calories
     */
    public function setCalories($calories)
    {
        $this->calories = $calories;

        return $this;
    }

    /**
     * Get calories
     *
     * @return string
     */
    public function getCalories()
    {
        return $this->calories;
    }

    /**
     * Set parentProduct
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Product $parentProduct
     * @return Product
     */
    public function setParentProduct(\OuiEatFrench\AdminBundle\Entity\Product $parentProduct = null)
    {
        $this->parentProduct = $parentProduct;

        return $this;
    }

    /**
     * Get parentProduct
     *
     * @return \OuiEatFrench\AdminBundle\Entity\Product 
     */
    public function getParentProduct()
    {
        return $this->parentProduct;
    }

    /**
     * Add season
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Season $season
     * @return Product
     */
    public function addSeason(\OuiEatFrench\AdminBundle\Entity\Season $season)
    {
        $this->season[] = $season;

        return $this;
    }

    /**
     * Remove season
     *
     * @param \OuiEatFrench\AdminBundle\Entity\Season $season
     */
    public function removeSeason(\OuiEatFrench\AdminBundle\Entity\Season $season)
    {
        $this->season->removeElement($season);
    }

    /**
     * Get season
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Add farmerProduct
     *
     * @param  $farmerProduct
     * @return Product
     */
    public function addFarmerProduct(OuiEatFrench\FarmerBundle\Entity\FarmerProduct $farmerProduct)
    {
        $this->farmerProducts[] = $farmerProduct;

        return $this;
    }

    /**
     * Remove farmerProducts
     *
     * @param OuiEatFrench\FarmerBundle\Entity\FarmerProduct $farmerProduct
     */
    public function removeFarmerProduct(OuiEatFrench\FarmerBundle\Entity\FarmerProduct $farmerProduct)
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
}
