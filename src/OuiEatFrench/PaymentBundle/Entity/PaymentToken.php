<?php

namespace OuiEatFrench\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * @ORM\Table(name="payment_token")
 * @ORM\Entity(repositoryClass="OuiEatFrench\PaymentBundle\Repository\PaymentTokenRepository")
 */
class PaymentToken extends Token
{
}