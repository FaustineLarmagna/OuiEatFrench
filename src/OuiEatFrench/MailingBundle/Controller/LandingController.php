<?php

namespace OuiEatFrench\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LandingController extends Controller
{
    public function indexAction()
    {
        return $this->render('OuiEatFrenchMailingBundle:Landing:index.html.twig');
    }
}
