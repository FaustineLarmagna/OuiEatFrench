<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    public function indexAction()
    {
        return $this->render('OuiEatFrenchPublicBundle:Account:index.html.twig');
    }
}
