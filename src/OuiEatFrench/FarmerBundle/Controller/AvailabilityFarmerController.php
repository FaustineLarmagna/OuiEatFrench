<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\AvailabilityFarmer;

class AvailabilityFarmerController extends Controller
{
    public function indexAction()
    {
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer || is_string($farmer)) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
        }

        $data['farmer'] = $farmer;
        $entity = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:AvailabilityFarmer')->findOneBy(array('farmer' => $farmer));
        if (!$entity)
        {
            $entity = new AvailabilityFarmer;
            $entity->setFarmer($farmer);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
        $data['entity'] = $entity;

        return $this->render('OuiEatFrenchFarmerBundle:AvailabilityFarmer:index.html.twig', $data);
    }

    public function editAction($id)
    {
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer || is_string($farmer)) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:AvailabilityFarmer')->findOneBy(array('id' => $id, 'farmer' => $farmer));
        $data = null;
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_farmerbundle_availabilityfarmertype", $query);
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_farmer_availability_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_farmer_availability_edit";
        }
        return $this->render('OuiEatFrenchFarmerBundle:AvailabilityFarmer:edit.html.twig', $data);
    }
}