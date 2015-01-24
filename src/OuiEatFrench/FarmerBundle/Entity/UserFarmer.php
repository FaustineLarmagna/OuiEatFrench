<?php

namespace OuiEatFrench\FarmerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserFarmer
 *
 * @ORM\Table(name="user_farmer")
 * @ORM\Entity
 */
class UserFarmer
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
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=45, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=45, nullable=false)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var integer
     *
     * @ORM\Column(name="postcode", length=5, type="integer", nullable=true)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="phone", type="integer", length=10, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=100, nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="company_street", type="string", length=255, nullable=true)
     */
    private $companyStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="company_postcode", type="integer", length=5, nullable=true)
     */
    private $companyPostcode;

    /**
     * @var string
     *
     * @ORM\Column(name="company_city", type="string", length=255, nullable=true)
     */
    private $companyCity;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    private $fileAvatar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_connection", type="date", nullable=true)
     */
    private $lastConnection;

    /**
     * @ORM\ManyToOne(targetEntity="\OuiEatFrench\AdminBundle\Entity\UserFarmerStatus", inversedBy="userFarmers")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /*
     * @ORM\OneToMany(targetEntity="FarmerProduct", mappedBy="farmer")
     */
    private $farmerProducts;


    public function __construct() {
        $this->farmerProducts = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     * @return UserFarmer
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
     * Set username
     *
     * @param string $username
     * @return UserFarmer
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return UserFarmer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return UserFarmer
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
     * @return UserFarmer
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
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return UserFarmer
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return UserFarmer
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postcode
     *
     * @param integer $postcode
     * @return UserFarmer
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return integer 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return UserFarmer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return UserFarmer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return UserFarmer
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set companyStreet
     *
     * @param string $companyStreet
     * @return UserFarmer
     */
    public function setCompanyStreet($companyStreet)
    {
        $this->companyStreet = $companyStreet;

        return $this;
    }

    /**
     * Get companyStreet
     *
     * @return string 
     */
    public function getCompanyStreet()
    {
        return $this->companyStreet;
    }

    /**
     * Set companyPostcode
     *
     * @param string $companyPostcode
     * @return UserFarmer
     */
    public function setCompanyPostcode($companyPostcode)
    {
        $this->companyPostcode = $companyPostcode;

        return $this;
    }

    /**
     * Get companyPostcode
     *
     * @return string 
     */
    public function getCompanyPostcode()
    {
        return $this->companyPostcode;
    }

    /**
     * Set companyCity
     *
     * @param string $companyCity
     * @return UserFarmer
     */
    public function setCompanyCity($companyCity)
    {
        $this->companyCity = $companyCity;

        return $this;
    }

    /**
     * Get companyCity
     *
     * @return string 
     */
    public function getCompanyCity()
    {
        return $this->companyCity;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return UserFarmer
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set fileAvatar
     *
     * @param string $avatar
     * @return UserFarmer
     */
    public function setFileAvatar($fileAvatar)
    {
        $this->fileAvatar = $fileAvatar;

        return $this;
    }

    /**
     * Get fileAvatar
     *
     * @return string 
     */
    public function getFileAvatar()
    {
        return $this->fileAvatar;
    }

    public function getUploadDir()
    {
        return 'OEF/user_farmer/avatar';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return UserFarmer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \OuiEatFrench\AdminBundle\Entity\UserFarmerStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set lastConnection
     *
     * @param \DateTime $lastConnection
     * @return UserFarmer
     */
    public function setLastConnection($lastConnection)
    {
        $this->lastConnection = $lastConnection;

        return $this;
    }

    /**
     * Get lastConnection
     *
     * @return \DateTime 
     */
    public function getLastConnection()
    {
        return $this->lastConnection;
    }

    public function getRoles()
    {
        return array('ROLE_USER_FARMER');
    }
}
