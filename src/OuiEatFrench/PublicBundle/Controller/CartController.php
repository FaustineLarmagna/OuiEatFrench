<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\PublicBundle\Entity\FarmerProductCart;
use OuiEatFrench\PublicBundle\Entity\Cart;

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

    public function addToCartAction($farmerProductId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $farmerProduct = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($farmerProductId);
        $farmerProductUnitType = $farmerProduct->getUnitType();
        if (empty($_POST['quantity']) || $_POST['quantity'] == 0 || !is_numeric($_POST['quantity']) || (is_float(floatval($_POST['quantity'])) && $farmerProductUnitType->getId() !== 1)) {
            $this->get('session')->getFlashBag()->add('error', "Quantité de produit invalide. Le produit n'a pas été ajouté à votre panier.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        if ($_POST['quantity'] > $farmerProduct->getUnitQuantity()) {
            //out of stock
            $this->get('session')->getFlashBag()->add('error', "Quantité de produit supérieure au stock de l'agriculteur. Le produit n'a pas été ajouté à votre panier.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array('user' => $user, 'status' => 1));
        if (!$cart) {
            $cartStatus = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->find(1);
            $date = new \DateTime();
            $cart = new Cart();
            $cart->setStatus($cartStatus);
            $cart->setUser($user);
            $cart->setCreatedAt($date);
            $cart->setUpdatedAt($date);
        
            $em->persist($cart);
        }

        $entity = new FarmerProductCart();
        $entity->setFarmerProduct($farmerProduct);
        $entity->setUnitQuantity($_POST['quantity']);
        $entity->setCart($cart);

        $farmerProductNewQuantity = $farmerProduct->getUnitQuantity() - $_POST['quantity'];
        $farmerProduct->setUnitQuantity($farmerProductNewQuantity);
        if ($farmerProductNewQuantity < $farmerProduct->getUnitMinimum()) {
        	$farmerProduct->setSelling(0);
        }

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
    }
}
