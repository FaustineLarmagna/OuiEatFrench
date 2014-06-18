<?php

namespace OuiEatFrench\MarketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MarketController extends Controller
{
    public function indexAction()
    {
        return $this->render('OuiEatFrenchMarketBundle:Market:index.html.twig');
    }
}
