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
                return $this->redirect($this->generateUrl('oui_eat_french_mailing_landing_index'));
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
                return $this->redirect($this->generateUrl('oui_eat_french_mailing_landing_index'));
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
        $formSeller = $this->createForm("ouieatfrench_mailingbundle_landingbothtype", $entity);
        if ($request->getMethod() == 'POST')
        {
            if($_POST['select'] == 'landing_customer')
                $origin = 'landing_customer';
            else
                $origin = 'landing_seller';

                $formSeller->bind($request);
                if ($formSeller->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $origin = $em->getRepository('OuiEatFrenchMailingBundle:Origin')->findOneBy(array('name' => $origin));
                    $entity->setOrigin($origin);
                    $em->persist($entity);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_mailing_landing_next'));
                }

        }
        $data["formBoth"] = $formSeller->createView();

        $data["route"] = "oui_eat_french_mailing_landing_next";

        return $this->render('OuiEatFrenchMailingBundle:Landing:next.html.twig', $data);
    }
}
