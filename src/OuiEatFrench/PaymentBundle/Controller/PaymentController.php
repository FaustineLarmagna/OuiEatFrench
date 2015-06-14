<?php

namespace OuiEatFrench\PaymentBundle\Controller;

use OuiEatFrench\PaymentBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Payum\Core\Registry\RegistryInterface;
use Payum\Core\Request\GetHumanStatus;
use Payum\Paypal\ExpressCheckout\Nvp\Api;
use Payum\Core\Security\GenericTokenFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentController extends Controller
{
    const TAX = 0.2;
    const SHIPPING_AMOUNT = 6.00;

    public function preparePaypalExpressCheckoutPaymentAction(Request $request)
        {
            $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.context')->getToken()->getUser();
            $status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->findOneByName("in_progress");    // id of status "in_progress"
            $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array(
                    'user' => $user,
                    'status' => $status,
                ));

            if (!$cart) {
                return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
            }

            $paymentName = 'ouieatfrench_command_paypal';

            $date = new \DateTime;
            $storage = $this->get('payum')->getStorage('OuiEatFrench\PaymentBundle\Entity\Order');
            $paymentDetails = $storage->create();
            $paymentDetails->setNumber(uniqid());
            $paymentDetails->setCurrencyCode('EUR');
            $paymentDetails->setDescription("Panier de l'utilisateur ".$user->getUsername()." le ".$date->format('d-m-Y'));
            $paymentDetails->setClient($user);
            $paymentDetails->setDate($date);

            $totalAmount = 0;
            $totalQuantity = 0;
            $i = 0;
            $farmers = array();
            foreach ($cart->getFarmerProductCarts() as $key => $farmerProductCart) {
                $i++;
                $farmerProduct = $farmerProductCart->getFarmerProduct();
                $farmerId = $farmerProduct->getFarmer()->getId();
                if (!in_array($farmerId, $farmers)) {
                    $farmers[] = $farmerId;
                }

                $product = $farmerProduct->getProduct();
                $quantity = $farmerProductCart->getUnitQuantity();
                $totalQuantity += $quantity;
                $amount = ($farmerProduct->getUnitPrice()*$quantity);
                $totalAmount += $amount;

                $paymentDetails['L_PAYMENTREQUEST_0_AMT'.$key] = $farmerProduct->getUnitPrice();
                $paymentDetails['L_PAYMENTREQUEST_0_QTY'.$key] = $quantity;
                $paymentDetails['L_PAYMENTREQUEST_0_NAME'.$key] = $product->getName();
                $paymentDetails['L_PAYMENTREQUEST_0_DESC'.$key] = $product->getDescription();
            }

            $shippingAmount = ($_GET['shipping'] == 0) ? count($farmers) * self::SHIPPING_AMOUNT : 0;
            $paymentDetails['LOCALECODE'] = 'FR';
            $paymentDetails['PAYMENTREQUEST_0_CURRENCYCODE'] = 'EUR';
            $paymentDetails['PAYMENTREQUEST_0_ITEMAMT'] = $totalAmount;
            $paymentDetails['PAYMENTREQUEST_0_TAXAMT'] = floor($totalAmount * self::TAX);
            $paymentDetails['PAYMENTREQUEST_0_SHIPPINGAMT'] = $shippingAmount;
            $paymentDetails['PAYMENTREQUEST_0_HANDLINGAMT'] = 0.00;
            $paymentDetails['PAYMENTREQUEST_0_QTY'] = $totalQuantity;
            $paymentDetails['PAYMENTREQUEST_0_AMT'] = $shippingAmount + $paymentDetails['PAYMENTREQUEST_0_TAXAMT'] + $totalAmount;
            $paymentDetails->setTotalAmount($totalAmount + $shippingAmount);

            $storage->update($paymentDetails);
            $captureToken = $this->getTokenFactory()->createCaptureToken(
                $paymentName,
                $paymentDetails,
                'oui_eat_french_payment_done'
            );
            $paymentDetails['INVNUM'] = $paymentDetails->getId();
            $storage->update($paymentDetails);
            return $this->redirect($captureToken->getTargetUrl());


        }

    public function doneAction(Request $request)
    {
        $token = $this->get('payum.security.http_request_verifier')->verify($request);
        
        return $this->redirect($this->generateUrl('oui_eat_french_public_cart_valid', array('order' => $token->getDetails()->getId())));
        
        // $gateway = $this->get('payum')->getGateway('ouieatfrench_command_paypal');
        // $gateway->execute($status = new GetHumanStatus($token));
        // $order = $status->getFirstModel();
        // $details = $order->getDetails();
        // var_dump($details);
        // return new JsonResponse(array(
        //     'status' => $status->getValue(),
        //     'response' => array(
        //         'order' => $order->getTotalAmount(),
        //         'currency_code' => $order->getCurrencyCode(),
        //         'details' => $order->getDetails(),
        //     ),
        // ));
    }

    /**
     * @return RegistryInterface
     */
    protected function getPayum()
    {
        return $this->get('payum');
    }
    /**
     * @return GenericTokenFactoryInterface
     */
    protected function getTokenFactory()
    {
        return $this->get('payum.security.token_factory');
    }
}