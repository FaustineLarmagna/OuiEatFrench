<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\AvailabilityFarmer;
use Symfony\Component\HttpFoundation\JsonResponse;

class AvailabilityFarmerController extends Controller
{
    public function ajaxHolidaysCheckBoxAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $checkbox = $request->request->get('checkbox');
            $farmer = $this->get('security.context')->getToken()->getUser();
            $farmer = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findOneBy(array('id' => $farmer->getId()));
            if ($checkbox == 'true')
            {
                $farmer->setHolidaysCheckbox(1);
            }
            else
            {
                $farmer->setHolidaysCheckbox(0);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmer);
            $em->flush();

            return new JsonResponse($checkbox);
        }
        return new JsonResponse();

    }

    public function indexAction()
    {
        $farmer = $this->get('security.context')->getToken()->getUser();

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
        $farmer = $this->get('security.context')->getToken()->getUser();

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
            $entity = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:AvailabilityFarmer')->findOneBy(array('farmer' => $farmer));
            $data["entity"] = $entity;
            $data["route"] = "oui_eat_french_farmer_availability_edit";
        }
        return $this->render('OuiEatFrenchFarmerBundle:AvailabilityFarmer:edit.html.twig', $data);
    }
}