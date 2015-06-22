<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FarmerController extends Controller
{
    public function indexAction()
    {
        return $this->render('OuiEatFrenchPublicBundle:Farmer:index.html.twig');
    }

    public function profilAction()
    {
        return $this->render('OuiEatFrenchPublicBundle:Farmer:profil.html.twig');
    }
}
