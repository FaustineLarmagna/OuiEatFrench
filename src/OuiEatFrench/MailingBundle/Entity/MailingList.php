<?php

namespace OuiEatFrench\MailingBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailingList
 *
 * @ORM\Table(name="mailing_list")
 * @ORM\Entity(repositoryClass="OuiEatFrench\MailingBundle\Repository\MailingListRepository")
 */
class MailingList
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
     * @ORM\Column(name="email", type="string", length=100)
     */
    protected $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    protected $firstname;


    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    protected $lastname;


    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="postcode", type="string", length=100)
     */
    protected $postcode;

    /**
     * @var \OuiEatFrench\MailingBundle\Entity\Origin
     *
     * @ORM\ManyToOne(targetEntity="OuiEatFrench\MailingBundle\Entity\Origin")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $origin;

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
     * Set email
     *
     * @param string $email
     * @return MailingList
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return MailingList
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return MailingList
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return MailingList
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->lastname;
    }

    /**
    * Set origin
    *
    * @param \OuiEatFrench\MailingBundle\Entity\Origin $origin
    * @return MailingList
    */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return \OuiEatFrench\MailingBundle\Entity\Origin
     */
    public function getOrigin()
    {
        return $this->origin;
    }

}
