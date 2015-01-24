<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findBy(array('parentProduct' => null));
        $data["products"] = $products;

        return $this->render('OuiEatFrenchPublicBundle:Product:index.html.twig', $data);
    }
}
