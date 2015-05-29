<?php

namespace OuiEatFrench\PaymentBundle\Controller;

class PaymentController extends Controller 
{
    public function preparePaypalAction(Request $request)
    {
        $gatewayName = 'ouieatfrench_command_paypal';

        $form = $this->createPurchaseForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();

            $storage = $this->getPayum()->getStorage('OuiEatFrench\PaymentBundle\Entity\PaymentDetails');

            /** @var $payment PaymentDetails */
            $payment = $storage->create();
            $payment['PAYMENTREQUEST_0_CURRENCYCODE'] = 'EUR';
            $payment['PAYMENTREQUEST_0_AMT'] = $data['amount'];
            $storage->update($payment);

            $captureToken = $this->getTokenFactory()->createCaptureToken(
                $gatewayName,
                $payment,
                'acme_payment_details_view'
            );

            $payment['INVNUM'] = $payment->getId();
            $storage->update($payment);

            return $this->redirect($captureToken->getTargetUrl());
        }

        return array(
            'form' => $form->createView(),
            'gatewayName' => $gatewayName
        );
    }

    // public function preparePaypalExpressCheckoutPaymentAction($amount)
    // {
    //     $user = $this->get('security.context')->getToken()->getUser();
    //     $gatewayName = 'paypal_express_checkout_nvp';

    //     $storage = $this->get('payum')->getStorage('OuiEatFrench\PaymentBundle\Entity\Payment');

    //     /** @var \OuiEatFrench\PaymentBundle\Entity\Payment $payment */
    //     $payment = $storage->create();
    //     $payment->setNumber(uniqid());
    //     $payment->setCurrencyCode('EUR');
    //     $payment->setTotalAmount($amount); // 123 = 1.23 EUR
    //     $payment->setDescription('Commande OuiEatFrench');
    //     $payment->setClientId($user->getId());
    //     $payment->setClientEmail($user->getEmail());

    //     $storage->update($payment);

    //     $captureToken = $this->get('payum.security.token_factory')->createCaptureToken(
    //         $gatewayName,
    //         $payment,
    //         'oui_eat_french_public_home' // the route to redirect after capture;
    //     );

    //     return $this->redirect($captureToken->getTargetUrl());
    // }

    // public function doneAction(Request $request)
    // {
    //     $token = $this->get('payum.security.http_request_verifier')->verify($request);

    //     $gateway = $this->get('payum')->getGateway($token->getGatewayName());

    //     // you can invalidate the token. The url could not be requested any more.
    //     // $this->get('payum.security.http_request_verifier')->invalidate($token);

    //     // Once you have token you can get the model from the storage directly. 
    //     //$identity = $token->getDetails();
    //     //$payment = $payum->getStorage($identity->getClass())->find($identity);

    //     // or Payum can fetch the model for you while executing a request (Preferred).
    //     $gateway->execute($status = new GetHumanStatus($token));
    //     $payment = $status->getFirstModel();

    //     // you have order and payment status 
    //     // so you can do whatever you want for example you can just print status and payment details.

    //     return new JsonResponse(array(
    //         'status' => $status->getValue(),
    //         'payment' => array(
    //             'total_amount' => $payment->getTotalAmount(),
    //             'currency_code' => $payment->getCurrencyCode(),
    //             'details' => $payment->getDetails(),
    //         ),
    //     ));
    // }
}