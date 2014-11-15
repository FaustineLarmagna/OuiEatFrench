<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FaqController extends Controller
{
    public function indexAction()
    {
        $faq = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Faq')->findBy(array('disable' => true));
        $data["faq"] = $faq;
        return $this->render('OuiEatFrenchPublicBundle:Faq:index.html.twig', $data);
    }
}
