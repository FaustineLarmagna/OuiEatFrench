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
        $data["formCustomer"] = $formCustomer->createView();

        $formSeller = $this->createForm("ouieatfrench_mailingbundle_landingsellertype", $entity);
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
        $data["formSeller"] = $formSeller->createView();

        $data["route"] = "oui_eat_french_mailing_landing_index";

        return $this->render('OuiEatFrenchMailingBundle:Landing:index.html.twig', $data);
    }
}
