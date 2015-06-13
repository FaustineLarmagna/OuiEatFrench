<?php

namespace OuiEatFrench\PaymentBundle\Model;

use Payum\Core\Model\ArrayObject;

class Order extends ArrayObject
{
    protected $id;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}