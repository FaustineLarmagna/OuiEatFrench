<?php

namespace OuiEatFrench\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use OuiEatFrench\PaymentBundle\Model\Order as BasePaymentDetails;

/**
 * @ORM\Table(name="order_details")
 * @ORM\Entity(repositoryClass="OuiEatFrench\PaymentBundle\Repository\OrderRepository")
 */
class Order extends BasePaymentDetails
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
     * @Assert\Email()
     * @ORM\Column(name="number", type="string", length=100)
     */
    private $number;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="datetime", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \OuiEatFrench\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\OuiEatFrench\UserBundle\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $client;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="total_amount", type="float")
     */
    private $total_amount;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="currency_code", type="text")
     */
    private $currency_code;

    protected $details;

    /**
     * @ORM\OneToOne(targetEntity="OuiEatFrench\PublicBundle\Entity\Cart", inversedBy="order")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    protected $cart;

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
     * Set number
     *
     * @param integer $number
     * @return Order
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Order
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
     * Set client
     *
     * @param \OuiEatFrench\UserBundle\Entity\User $client
     * @return Order
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \OuiEatFrench\UserBundle\Entity\User 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set total_amount
     *
     * @param float $totalAmount
     * @return Order
     */
    public function setTotalAmount($totalAmount)
    {

        $this->total_amount = $totalAmount;
        return $this;
    }

    /**
     * Get total_amount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    /**
     * Set currency_code
     *
     * @param string $currencyCode
     * @return Order
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currency_code = $currencyCode;

        return $this;
    }

    /**
     * Get currency_code
     *
     * @return string 
     */
    public function getCurrencyCode()
    {
        return $this->currency_code;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return Order
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set cart
     *
     * @param \OuiEatFrench\PublicBundle\Entity\Cart $cart
     *
     * @return Order
     */
    public function setCart(\OuiEatFrench\PublicBundle\Entity\Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \OuiEatFrench\PublicBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Order
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
