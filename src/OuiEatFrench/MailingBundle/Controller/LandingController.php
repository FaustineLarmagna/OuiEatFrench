<?php

namespace OuiEatFrench\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\MailingBundle\Entity\MailingList;

class LandingController extends Controller
{
    public function indexAction()
    {
        $entity = new MailingList();
        $request = $this->get("request");

        if(isset($_POST['customer']))
        {
            $data["formSellerValid"] = 2;
            $data["formCustomerValid"] = 0;
        }
        else
        {
            $data["formSellerValid"] = 0;
            $data["formCustomerValid"] = 2;
        }

        $formCustomer = $this->createForm("ouieatfrench_mailingbundle_landingcustomertype", $entity);

        if ($request->getMethod() == 'POST')
        {
            $formCustomer->bind($request);
            if ($formCustomer->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $origin = $em->getRepository('OuiEatFrenchMailingBundle:Origin')->findOneBy(array('name' => 'landing_customer'));
                $entity->setOrigin($origin);
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('customer_success', 'Votre demande a été validée.');

                return $this->redirect($this->generateUrl('oui_eat_french_mailing_landing_index').'#forms');
            }
        }
        $data["formCustomer"] = $formCustomer->createView();

        $formSeller = $this->createForm("ouieatfrench_mailingbundle_landingsellertype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $formSeller->bind($request);
            if ($formSeller->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $origin = $em->getRepository('OuiEatFrenchMailingBundle:Origin')->findOneBy(array('name' => 'landing_seller'));
                $entity->setOrigin($origin);
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('seller_success', 'Votre demande a été validée.');

                return $this->redirect($this->generateUrl('oui_eat_french_mailing_landing_index').'#forms');
            }
        }
        $data["formSeller"] = $formSeller->createView();
        $data["route"] = "oui_eat_french_mailing_landing_index";

        return $this->render('OuiEatFrenchMailingBundle:Landing:index.html.twig', $data);
    }

    public function nextAction()
    {
        $entity = new MailingList();
        $request = $this->get("request");
        $formBoth = $this->createForm("ouieatfrench_mailingbundle_landingbothtype", $entity);
        if ($request->getMethod() == 'POST')
        {
            if($_POST['select'] == 'landing_customer')
                $originSelect = 'landing_customer';
            else
                $originSelect = 'landing_seller';

            $formBoth->bind($request);
            if ($formBoth->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $origin = $em->getRepository('OuiEatFrenchMailingBundle:Origin')->findOneBy(array('name' => $originSelect));
                $entity->setOrigin($origin);
                $em->persist($entity);
                $em->flush();
                $entity = new MailingList();
                $request = $this->get("request");
                $formBoth = $this->createForm("ouieatfrench_mailingbundle_landingbothtype", $entity);
                $data["formBothValid"] = 1;
                $data["route"] = "oui_eat_french_mailing_landing_next";
                $data["formBoth"] = $formBoth->createView();
                return $this->render('OuiEatFrenchMailingBundle:Landing:next.html.twig', $data);
            }
        }
        $data["formBothValid"] = 0;
        $data["formBoth"] = $formBoth->createView();

        $data["route"] = "oui_eat_french_mailing_landing_next";

        return $this->render('OuiEatFrenchMailingBundle:Landing:next.html.twig', $data);
    }
}
