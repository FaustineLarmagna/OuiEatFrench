<?php

namespace OuiEatFrench\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CommandStatus
 *
 * @ORM\Table(name="command_status")
 * @ORM\Entity()
 */
class CommandStatus
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="string", length=255)
     */
    private $translation;

    /**
     * @ORM\OneToMany(targetEntity="OuiEatFrench\FarmerBundle\Entity\Command", mappedBy="status")
     */
    protected $commands;

    public function __construct() {
        $this->commands = new ArrayCollection();
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
     * @return CommandStatus
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
     * Set translation
     *
     * @param string $translation
     * @return CartStatus
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return string 
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Add command
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\Command $command
     *
     * @return CommandStatus
     */
    public function addCommand(\OuiEatFrench\FarmerBundle\Entity\Command $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Remove command
     *
     * @param \OuiEatFrench\FarmerBundle\Entity\Command $command
     */
    public function removeCommand(\OuiEatFrench\FarmerBundle\Entity\Command $command)
    {
        $this->commands->removeElement($command);
    }

    /**
     * Get commands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommands()
    {
        return $this->commands;
    }
}
