<?php

namespace OuiEatFrench\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailingController extends Controller
{
    public function indexAction()
    {
        return $this->render('OuiEatFrenchMailingBundle:Mailing:index.html.twig');
    }
}
