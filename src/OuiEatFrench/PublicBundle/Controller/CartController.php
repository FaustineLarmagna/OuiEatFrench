<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use OuiEatFrench\PublicBundle\Entity\FarmerProductCart;
use OuiEatFrench\PublicBundle\Entity\Cart;
use OuiEatFrench\FarmerBundle\Entity\FarmerProductClone;
use OuiEatFrench\FarmerBundle\Entity\Command;

class CartController extends Controller
{
    public function showAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->findOneByName("in_progress");	// id of status "in_progress"
    	$courgette = $em->getRepository('OuiEatFrenchAdminBundle:Product')->findOneByName('Courgette');
        $chouFleur = $em->getRepository('OuiEatFrenchAdminBundle:Product')->findOneByName('Chou-fleur');
        $framboise = $em->getRepository('OuiEatFrenchAdminBundle:Product')->findOneByName('Framboise');
        $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array(
    			'user' => $user,
    			'status' => $status
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

        return $this->render('OuiEatFrenchPublicBundle:Cart:show.html.twig', array(
            'user' => $user,
            'cart' => $cart,
            'courgette' => $courgette,
            'chou_fleur' => $chouFleur,
            'framboise' => $framboise
        ));
    }

    public function addToCartAction($farmerProductId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $farmerProduct = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($farmerProductId);
        $farmerProductUnitType = $farmerProduct->getProduct()->getUnitType();

        // checking $_POST['quantity'] format
        if (empty($_POST['quantity']) || $_POST['quantity'] == 0 || !is_numeric($_POST['quantity']) || (is_numeric($_POST['quantity']) && floor(floatval($_POST['quantity'])) != floatval($_POST['quantity']) && $farmerProductUnitType->getName() !== 'kg')) {
            $this->get('session')->getFlashBag()->add('error', "Quantité de produit invalide. Le produit n'a pas été ajouté à votre panier.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        if ($_POST['quantity'] > $farmerProduct->getUnitQuantity()) {
            //out of stock
            $this->get('session')->getFlashBag()->add('error', "Quantité de produit supérieure au stock de l'agriculteur. Le produit n'a pas été ajouté à votre panier.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        $number = $_POST['quantity'] * $farmerProduct->getUnitPrice();
        if ($_POST['price'] != number_format((float)$number, 2, '.', '')) {
            //wrong price given
            $this->get('session')->getFlashBag()->add('error', "Le prix indiqué ne correspondait pas à la quantité demandée et a donc été ajusté.");
        }

        // finding the user's current cart. If he has no in_progress cart, creating one
        $status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->findOneByName("in_progress");
        $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array('user' => $user, 'status' => $status));
        if (!$cart) {
            $date = new \DateTime();
            $cart = new Cart();
            $cart->setStatus($status);
            $cart->setUser($user);
            $cart->setCreatedAt($date);
            $cart->setUpdatedAt($date);
        
            $em->persist($cart);
        }

        // creating the entity that register products in carts
        $entity = new FarmerProductCart();
        $entity->setFarmerProduct($farmerProduct);
        $entity->setUnitQuantity($_POST['quantity']);
        $entity->setCart($cart);

        // cart has been updated so we change the value of his attribute updatedAt
        $date = new \DateTime();
        $cart->setUpdatedAt($date);

        // removing quantity to the farmer's stock. Checking if there are still enough product according to the unitMinimum attribute
        $farmerProductNewQuantity = $farmerProduct->getUnitQuantity() - $_POST['quantity'];
        $farmerProduct->setUnitQuantity($farmerProductNewQuantity);
        if ($farmerProductNewQuantity < $farmerProduct->getUnitMinimum()) {
        	$farmerProduct->setSelling(0);
        }

        $em->persist($entity);
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
        $cart = $farmerProductCart->getCart();
        $date = new \DateTime();
        $cart->setUpdatedAt($date);

        $em->flush();

        return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
    }

    public function resetCartAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->findOneByName("in_progress");
        $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array(
                'user' => $user,
                'status' => $status,
            ));

        if (!$cart) {
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        $farmerProductCarts = $em->getRepository('OuiEatFrenchPublicBundle:FarmerProductCart')->findBy(array('cart' => $cart));
        // removing every entities in cart so that the cart become empty
        foreach($farmerProductCarts as $farmerProductCart) {
            $farmerProduct = $farmerProductCart->getFarmerProduct();
            $farmerProductNewQuantity = $farmerProduct->getUnitQuantity() + $farmerProductCart->getUnitQuantity();
            $farmerProduct->setUnitQuantity($farmerProductNewQuantity);
            $em->remove($farmerProductCart);
        }

        $date = new \DateTime();
        $cart->setUpdatedAt($date);

        $em->flush();

        return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
    }

    public function validCartAction($order) 
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('OuiEatFrenchPaymentBundle:Order')->find($order);
        if (!$order) {
            $this->get('session')->getFlashBag()->add('error', "Une erreur s'est produite. Si l'erreur persiste, veuillez contacter un administrateur.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        $user = $this->get('security.context')->getToken()->getUser();
        if ($user != $order->getClient() || $order->getDetails()['ACK'] !== "Success") {
            $this->get('session')->getFlashBag()->add('error', "Une erreur s'est produite. Si l'erreur persiste, veuillez contacter un administrateur.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

        $status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->findOneByName("in_progress");    // id of status "in_progress"
        $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array(
                'user' => $user,
                'status' => $status,
            ));

        if (!$cart) {
            $this->get('session')->getFlashBag()->add('error', "Une erreur s'est produite. Si l'erreur persiste, veuillez contacter un administrateur.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
        }

    // add order to cart
        $cart->setOrder($order);
        $order->setCart($cart);

    // change cart's status to "paid"
        $newStatus = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->findOneByName("paid");
        $date = new \DateTime();
        $cart->setStatus($newStatus);
        $cart->setUpdatedAt($date);

    // create a new empty cart with status "in_progress" (which is first step)
        $newDate = new \DateTime();
        $newCart = new Cart();
        $newCart->setStatus($status);
        $newCart->setUser($user);
        $newCart->setCreatedAt($date);
        $newCart->setUpdatedAt($date);

        $em->persist($newCart);
        
    // create a command for each farmer concerned by this cart (which sells one or more product in this cart)
        $farmerCommand = array();
        $commandStatus = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName("paid");
        foreach ($cart->getFarmerProductCarts() as $farmerProductCart) {
            $farmerProduct = $farmerProductCart->getFarmerProduct();
            $farmerProductClone = new FarmerProductClone($farmerProduct);
            $farmerProductClone->setQuantity($farmerProductCart->getUnitQuantity());

            $key = $farmerProduct->getFarmer()->getId();
            if (array_key_exists($key, $farmerCommand)) {
                $farmerProductClone->setCommand($farmerCommand[$key]['command']);
            } else {
                $command = new Command();
                $command->setCart($cart);
                $command->setFarmer($farmerProduct->getFarmer());
                $command->setStatus($commandStatus);
                $command->setDate(new \DateTime);
                
                $em->persist($command);
                $farmerProductClone->setCommand($command);
                $farmerCommand[$key]['command'] = $command;
            }

            $farmerCommand[$key]['products'][] = $farmerProductClone;
        }

        foreach ($farmerCommand as $farmer => $array) {
            foreach ($array['products'] as $product) {
                $em->persist($product);
            }
        }

        $em->flush();
        $this->get('session')->getFlashBag()->add('success', "Commande validée avec succès, vous recevrez bientôt un email de confirmation.");

        return $this->redirect($this->generateUrl('oui_eat_french_public_cart_show'));
    }

    public function identificationAction($shipping)
    {
        return $this->render('OuiEatFrenchPublicBundle:Cart:identification.html.twig', array('shipping' => $shipping));
    }

    public function livraisonAction($shipping)
    {
        return $this->render('OuiEatFrenchPublicBundle:Cart:livraison.html.twig', array('shipping' => $shipping));
    }

    public function recapitulatifAction($shipping)
    {
        return $this->render('OuiEatFrenchPublicBundle:Cart:recapitulatif.html.twig', array('shipping' => $shipping));
    }

    public function changeQuantityAction() 
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $quantity = $request->request->get('quantity');
            $em = $this->getDoctrine()->getManager();

            $query = $em->getRepository('OuiEatFrenchPublicBundle:FarmerProductCart')->find($id);
            if ($query)
            {
                $query->setUnitQuantity($quantity);
                $cart = $query->getCart();
                $date = new \DateTime();
                $cart->setUpdatedAt($date);

                $em->flush();

                return new JsonResponse($quantity);
            }

            return new JsonResponse('null');
        }

        return new JsonResponse('null');
    }

    public function removeFromCartAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $farmerProductCart = $em->getRepository('OuiEatFrenchPublicBundle:FarmerProductCart')->find($id);
            if (!$farmerProductCart) {
                return new JsonResponse('null');
            }
            
            $farmerProduct = $farmerProductCart->getFarmerProduct();
            
            $farmerProductNewQuantity = $farmerProduct->getUnitQuantity() + $farmerProductCart->getUnitQuantity();
            $farmerProduct->setUnitQuantity($farmerProductNewQuantity);

            // removing entity and changing updatedAt attribute in the cart
            $em->remove($farmerProductCart);
            $cart = $farmerProductCart->getCart();
            $date = new \DateTime();
            $cart->setUpdatedAt($date);

            $em->flush();

            return new JsonResponse($id);
        }

        return new JsonResponse('null');
    }
}