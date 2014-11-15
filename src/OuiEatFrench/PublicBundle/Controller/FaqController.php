<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FaqController extends Controller
{
    public function indexAction()
    {
        $faqs = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Faq')->findBy(array('disable' => true));
        $data["faqs"] = $faqs;
        return $this->render('OuiEatFrenchPublicBundle:Faq:index.html.twig', $data);
    }
}
