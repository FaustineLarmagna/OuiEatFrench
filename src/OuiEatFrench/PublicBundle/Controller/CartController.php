<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\PublicBundle\Entity\FarmerProductCart;

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

    public function addToCartAction($farmerProductId, $quantity)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $farmerProduct = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($farmerProductId);

        $entity = new FarmerProductCart();
        $entity->setUser($user);
        $entity->setFarmerProduct($farmerProduct);
        $entity->setUnitQuantity($quantity);-

        $farmerProductNewQuantity = $farmerProduct->getUnitQuantity() - $quantity;
        $farmerProduct->setUnitQuantity($farmerProductNewQuantity);
        if ($farmerProductNewQuantity < $farmerProduct->getUnitMinimym()) {
        	$farmerProduct->setSelling(0);
        }

        $em->persist($entity);
        $em->flush();

        $data["cart"] = $cart;
        $data["user"] = $user;
        return $this->render('OuiEatFrenchPublicBundle:Cart:show.html.twig', $data);
    }
}
