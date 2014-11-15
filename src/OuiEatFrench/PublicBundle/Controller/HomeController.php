<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $edito = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Edito')->findAll();
        $data["edito"] = $edito;
        var_dump($data);
        return $this->render('OuiEatFrenchPublicBundle:Home:index.html.twig');
    }
}
