<?php

namespace OuiEatFrench\LandingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LandingController extends Controller
{
    public function indexAction()
    {
        return $this->render('OuiEatFrenchLandingBundle:Landing:index.html.twig');
    }
}
