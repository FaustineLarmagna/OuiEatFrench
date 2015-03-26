<?php

namespace OuiEatFrench\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_admin")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="username", type="string", length=100)
     */
    protected $username;

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
     * @ORM\Column(name="password", type="string", length=100)
     */
    protected $password;

    public function __construct()
    {

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
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = sha1($password);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return sha1($this->password);
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
