<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $edito = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Edito')->findOneBy(array('disable' => true));
        $data["edito"] = $edito;

        return $this->render('OuiEatFrenchPublicBundle:Home:index.html.twig', $data);
    }
}
