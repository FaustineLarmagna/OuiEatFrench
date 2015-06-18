<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FarmerController extends Controller
{
    public function indexAction()
    {
        return $this->render('OuiEatFrenchPublicBundle:Farmer:index.html.twig');
    }
}
