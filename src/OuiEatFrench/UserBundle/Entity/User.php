<?php

namespace OuiEatFrench\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\PublicBundle\Entity\Cart", mappedBy="user")
     */
    protected $carts;


    public function __construct()
    {
        parent::__construct();

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

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Add carts
     *
     * @param \OuiEatFrench\PublicBundle\Entity\Cart $carts
     * @return User
     */
    public function addCart(\OuiEatFrench\PublicBundle\Entity\Cart $carts)
    {
        $this->carts[] = $carts;

        return $this;
    }

    /**
     * Remove carts
     *
     * @param \OuiEatFrench\PublicBundle\Entity\Cart $carts
     */
    public function removeCart(\OuiEatFrench\PublicBundle\Entity\Cart $carts)
    {
        $this->carts->removeElement($carts);
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
