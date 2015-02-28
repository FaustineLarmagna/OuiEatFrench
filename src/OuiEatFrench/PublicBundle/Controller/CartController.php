<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller
{
    public function showAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->find(1);	// id of status "in_progress"
    	$cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array(
    			'user' => $user,
    			'status' => $status,
    		));

        return $this->render('OuiEatFrenchPublicBundle:Cart:show.html.twig', array('user' => $user, 'cart' => $cart));
    }

    public function commandAction()
   	{
        return $this->redirect($this->generateUrl('oui_eat_french_public_panier_show'));
   	}
}
