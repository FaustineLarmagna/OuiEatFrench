<?php

namespace OuiEatFrench\MailingBundle\Entity;

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
     * @ORM\Column(name="email", type="string", length=100)
     */
    protected $email;

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
    * Set origin
    *
    * @param \OuiEatFrench\MailingBundle\Entity\Origin $origin
    * @return Origin
    */
    public function setOrigin($origin)
    {
        $this->$origin = $origin;

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
