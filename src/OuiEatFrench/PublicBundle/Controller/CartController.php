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

        if (!$cart) {
            $date = new \DateTime();
            $cart = new Cart();
            $cart->setStatus($status);
            $cart->setUser($user);
            $cart->setCreatedAt($date);
            $cart->setUpdatedAt($date);
        
            $em->persist($cart);
            $em->flush();
        }

        return $this->render('OuiEatFrenchPublicBundle:Cart:show.html.twig', array('user' => $user, 'cart' => $cart));
    }

    public function addToCartAction($farmerProductId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $farmerProduct = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($farmerProductId);
        $farmerProductUnitType = $farmerProduct->getUnitType();

        if (empty($_POST['quantity']) || $_POST['quantity'] == 0 || !is_numeric($_POST['quantity']) || (is_numeric($_POST['quantity']) && floor(floatval($_POST['quantity'])) != floatval($_POST['quantity']) && $farmerProductUnitType->getId() !== 1)) {
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

    public function removeFromCartAction($farmerProductCartId)
    {
        $em = $this->getDoctrine()->getManager();
        $farmerProductCart = $em->getRepository('OuiEatFrenchPublicBundle:FarmerProductCart')->find($farmerProductCartId);
        $farmerProduct = $farmerProductCart->getFarmerProduct();
        
        $farmerProductNewQuantity = $farmerProduct->getUnitQuantity() + $farmerProductCart->getUnitQuantity();
        $farmerProduct->setUnitQuantity($farmerProductNewQuantity);

        $em->remove($farmerProductCart);
        $em->flush();

        return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
    }

    public function modifyProductInCartAction($farmerProductCartId)
    {
        if (empty($_POST['quantity']) || $_POST['quantity'] == 0 || !is_numeric($_POST['quantity']) || (is_numeric($_POST['quantity']) && floor(floatval($_POST['quantity'])) != floatval($_POST['quantity']) && $farmerProductUnitType->getId() !== 1)) {
            $this->get('session')->getFlashBag()->add('error', "Quantité de produit invalide. Le produit n'a pas été modifié.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
        }

        $em = $this->getDoctrine()->getManager();
        $farmerProductCart = $em->getRepository('OuiEatFrenchPublicBundle:FarmerProductCart')->find($farmerProductCartId);
        $farmerProduct = $farmerProductCart->getFarmerProduct();

        if ($_POST['quantity'] > $farmerProduct->getUnitQuantity()) {
            //out of stock
            $this->get('session')->getFlashBag()->add('error', "Quantité de produit supérieure au stock de l'agriculteur. Le produit n'a pas été modifié.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
        }

        $farmerProductNewQuantity = ($farmerProduct->getUnitQuantity() + $farmerProductCart->getUnitQuantity()) - $_POST['quantity'];
        $farmerProduct->setUnitQuantity($farmerProductNewQuantity);
        if ($farmerProductNewQuantity < $farmerProduct->getUnitMinimum()) {
            $farmerProduct->setSelling(0);
        }

        $farmerProductCart->setUnitQuantity($_POST['quantity']);

        $em->flush();

        return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
    }

    public function resetCartAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->find(1);    // id of status "in_progress"
        $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array(
                'user' => $user,
                'status' => $status,
            ));

        if (!$cart) {
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        $farmerProductCarts = $em->getRepository('OuiEatFrenchPublicBundle:FarmerProductCart')->findBy(array('cart' => $cart));
        
        foreach($farmerProductCarts as $farmerProductCart) {
            $farmerProduct = $farmerProductCart->getFarmerProduct();
            $farmerProductNewQuantity = $farmerProduct->getUnitQuantity() + $farmerProductCart->getUnitQuantity();
            $farmerProduct->setUnitQuantity($farmerProductNewQuantity);
            $em->remove($farmerProductCart);
        }

        $em->flush();

        return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
    }

    public function validCartAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->find(1);    // id of status "in_progress"
        $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array(
                'user' => $user,
                'status' => $status,
            ));

        if (!$cart) {
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        /*
                LE PAIEMENT S'EFFECTUE ICI
        */

        $newStatus = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->find(2); // id of status "paid"
        $date = new \DateTime();
        $cart->setStatus($newStatus);
        $cart->setUpdatedAt($date);

        $newDate = new \DateTime();
        $newCart = new Cart();
        $newCart->setStatus($status);
        $newCart->setUser($user);
        $newCart->setCreatedAt($date);
        $newCart->setUpdatedAt($date);
        
        $em->persist($newCart);
        $em->flush();

        return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
    }
}
