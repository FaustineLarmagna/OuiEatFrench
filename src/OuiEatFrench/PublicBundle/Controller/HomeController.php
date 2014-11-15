<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $editos = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Edito')->findBy(array('disable' => true));
        $data["editos"] = $editos;
        return $this->render('OuiEatFrenchPublicBundle:Home:index.html.twig', $data);
    }
}
