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

    public function addToCartAction($farmerProductId)
    {
        if (empty($_POST['quantity']) || $_POST['quantity'] == 0 || !is_float($_POST['quantity'])) {
            $this->addFlash('error', "Quantité de produit invalide. Le produit n'a pas été ajouté à votre panier.");
            return $this->render('OuiEatFrenchPublicBundle:Product:index.html.twig');
        }

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $farmerProduct = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($farmerProductId);

        if ($_POST['quantity'] > $farmerProduct->getUnitQuantity()) {
            //out of stock
            $this->addFlash('error', "Quantité de produit supérieure au stock de l'agriculteur. Le produit n'a pas été ajouté à votre panier.");
            return $this->render('OuiEatFrenchPublicBundle:Product:index.html.twig');
        }

        $entity = new FarmerProductCart();
        $entity->setUser($user);
        $entity->setFarmerProduct($farmerProduct);
        $entity->setUnitQuantity($_POST['quantity']);

        $farmerProductNewQuantity = $farmerProduct->getUnitQuantity() - $_POST['quantity'];
        $farmerProduct->setUnitQuantity($farmerProductNewQuantity);
        if ($farmerProductNewQuantity < $farmerProduct->getUnitMinimum()) {
        	$farmerProduct->setSelling(0);
        }

        $em->persist($entity);
        $em->flush();

        $data["cart"] = $cart;
        $data["user"] = $user;
        return $this->render('OuiEatFrenchPublicBundle:Cart:show.html.twig', $data);
    }
}
