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

    // public function preparePaypalExpressCheckoutPaymentAction()
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $user = $this->get('security.context')->getToken()->getUser();
    //     $status = $em->getRepository('OuiEatFrenchAdminBundle:CartStatus')->findOneByName("in_progress");    // id of status "in_progress"
    //     $cart = $em->getRepository('OuiEatFrenchPublicBundle:Cart')->findOneBy(array(
    //             'user' => $user,
    //             'status' => $status,
    //         ));

    //     if (!$cart) {
    //         return $this->redirect($this->generateUrl('oui_eat_french_public_product_index'));
    //     }

    //     $paymentName = 'ouieatfrench_command_paypal';
    //     $date = new \DateTime;
    //     $storage = $this->get('payum')->getStorage('OuiEatFrench\PaymentBundle\Entity\Order');
    //     $paymentDetails = $storage->create();
    //     $paymentDetails->setNumber(uniqid());
    //     $paymentDetails->setCurrencyCode('EUR');
    //     $paymentDetails->setDescription("Panier de l'utilisateur ".$user->getUsername()." le ".$date->format('d-m-Y'));
    //     $paymentDetails->setClient($user);

    //     $totalAmount = 0;
    //     foreach ($cart->getFarmerProductCarts() as $key => $farmerProductCart) {
    //         $farmerProduct = $farmerProductCart->getFarmerProduct();
    //         $product = $farmerProduct->getProduct();
    //         $amount = ($farmerProduct->getUnitPrice()*$farmerProductCart->getUnitQuantity());
    //         $totalAmount += $amount;

    //         $paymentDetails['L_PAYMENTREQUEST_0_AMT'.$key] = $farmerProduct->getUnitPrice();
    //         $paymentDetails['L_PAYMENTREQUEST_0_QTY'.$key] = $farmerProductCart->getUnitQuantity();
    //         $paymentDetails['L_PAYMENTREQUEST_0_NAME'.$key] = $product->getName();
    //         $paymentDetails['L_PAYMENTREQUEST_0_DESC'.$key] = $product->getDescription();
    //     }
    //     var_dump($paymentDetails);

    //     $paymentDetails['PAYMENTREQUEST_0_CURRENCYCODE'] = 'EUR';
    //     $paymentDetails['PAYMENTREQUEST_0_AMT'] = $totalAmount;
    //     $paymentDetails['PAYMENTREQUEST_0_TAXAMT']=$totalAmount * self::TAX;
    //     // $paymentDetails['PAYMENTREQUEST_0_SHIPPINGAMT']=self::SHIPPING_AMOUNT;
    //     $paymentDetails['PAYMENTREQUEST_0_HANDLINGAMT']=0.00;
    //     $paymentDetails['NOSHIPPING'] = Api::NOSHIPPING_NOT_DISPLAY_ADDRESS;
    //     $paymentDetails['REQCONFIRMSHIPPING'] = Api::REQCONFIRMSHIPPING_NOT_REQUIRED;
    //     $paymentDetails->setTotalAmount($totalAmount);

    //     $storage->update($paymentDetails);
    //     $captureToken = $this->getTokenFactory()->createCaptureToken(
    //         $paymentName,
    //         $paymentDetails,
    //         'oui_eat_french_payment_done'
    //     );
    //     $paymentDetails['INVNUM'] = $paymentDetails->getId();
    //     $storage->update($paymentDetails);

    //     return $this->redirect($captureToken->getTargetUrl());
    // }
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
            $eBook = array(
                'author' => 'Jules Verne',
                'name' => 'The Mysterious Island',
                'description' => 'The Mysterious Island is a novel by Jules Verne, published in 1874.',
                'price' => 8.64,
                'currency_symbol' => '$',
                'currency' => 'USD'
            );

            $date = new \DateTime;
            $storage = $this->get('payum')->getStorage('OuiEatFrench\PaymentBundle\Entity\Order');
            $paymentDetails = $storage->create();
            $paymentDetails->setNumber(uniqid());
            $paymentDetails->setCurrencyCode('EUR');
            $paymentDetails->setDescription("Panier de l'utilisateur ".$user->getUsername()." le ".$date->format('d-m-Y'));
            $paymentDetails->setClient($user);

            $paymentDetails['LOCALECODE'] = 'FR';

            $totalAmount = 0;
            foreach ($cart->getFarmerProductCarts() as $key => $farmerProductCart) {
                $farmerProduct = $farmerProductCart->getFarmerProduct();
                $product = $farmerProduct->getProduct();
                $amount = ($farmerProduct->getUnitPrice()*$farmerProductCart->getUnitQuantity());
                $totalAmount += $amount;

                $paymentDetails['L_PAYMENTREQUEST_0_AMT'.$key] = $farmerProduct->getUnitPrice();
                $paymentDetails['L_PAYMENTREQUEST_0_QTY'.$key] = $farmerProductCart->getUnitQuantity();
                $paymentDetails['L_PAYMENTREQUEST_0_NAME'.$key] = $product->getName();
                $paymentDetails['L_PAYMENTREQUEST_0_DESC'.$key] = $product->getDescription();
            }

            $paymentDetails['PAYMENTREQUEST_0_CURRENCYCODE'] = 'EUR';
            $paymentDetails['PAYMENTREQUEST_0_AMT'] = $totalAmount;
            // $paymentDetails['PAYMENTREQUEST_0_SHIPPINGAMT'] = 6.55;
            $paymentDetails->setTotalAmount($totalAmount);

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
        var_dump($token);

        // return $this->redirect($this->generateUrl('oui_eat_french_public_cart_valid', array('order' => $token->getDetails()->getId())));

        $gateway = $this->get('payum')->getGateway('ouieatfrench_command_paypal');

        // you can invalidate the token. The url could not be requested any more.
        // $this->get('payum.security.http_request_verifier')->invalidate($token);

        // Once you have token you can get the model from the storage directly.
        //$identity = $token->getDetails();
        //$order = $payum->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $order = $status->getFirstModel();

        // you have order and payment status
        // so you can do whatever you want for example you can just print status and payment details.

        return new JsonResponse(array(
            'status' => $status->getValue(),
            'response' => array(
                'order' => $order->getTotalAmount(),
                'currency_code' => $order->getCurrencyCode(),
                'details' => $order->getDetails(),
            ),
        ));
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