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
            // $farmer = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findOneBy(array('id' => $farmer->getId()));
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

    public function ajaxSlotAddAction() {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $slotMachineName = $request->request->get('slot_machine_name');
            $em = $this->getDoctrine()->getManager();
            $slot = $em->getRepository('OuiEatFrenchFarmerBundle:AvailabilitySlot')->findOneByMachineName($slotMachineName);
            if (!$slot) {
                return new JsonResponse('failed');
            }

            $farmer = $this->get('security.context')->getToken()->getUser();
            $availabilityFarmer = $em->getRepository('OuiEatFrenchFarmerBundle:AvailabilityFarmer')->findOneByFarmer($farmer);
            if (!$availabilityFarmer) {
                $availabilityFarmer = new AvailabilityFarmer();
                $availabilityFarmer->setFarmer($farmer);
                $em->persist($availabilityFarmer);
            }

            $availabilityFarmer->addAvailabilitySlot($slot);
            $em->flush();

            return new JsonResponse($slotMachineName);
        }

        return new JsonResponse('failed');
    }

    public function ajaxSlotRemoveAction() {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $slotMachineName = $request->request->get('slot_machine_name');
            $farmer = $this->get('security.context')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();
            $slot = $em->getRepository('OuiEatFrenchFarmerBundle:AvailabilitySlot')->findOneByMachineName($slotMachineName);
            if (!$slot) {
                return new JsonResponse();
            }

            $availability = $em->getRepository('OuiEatFrenchFarmerBundle:AvailabilityFarmer')->findOneByFarmerAndSlot($farmer, $slot);
            if (!$availability) {
                return new JsonResponse('failed');
            }

            $availability->removeAvailabilitySlot($slot);
            $em->flush();

            return new JsonResponse($slotMachineName);
        }

        return new JsonResponse('failed');
    }


    public function indexAction()
    {
        $farmer = $this->get('security.context')->getToken()->getUser();

        $data['farmer'] = $farmer;
        $entity = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:AvailabilityFarmer')->findOneByFarmer($farmer);
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

    public function editAction()
    {
        $farmer = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:AvailabilityFarmer')->findOneByFarmer($farmer);
        $data = array();
        if(!$query)
        {
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_availability_index'));
        }

        $data["id"] = $query->getId();
        $data["entity"] = $query;
        $data["route"] = "oui_eat_french_farmer_availability_edit";

        return $this->render('OuiEatFrenchFarmerBundle:AvailabilityFarmer:edit.html.twig', $data);
    }
}