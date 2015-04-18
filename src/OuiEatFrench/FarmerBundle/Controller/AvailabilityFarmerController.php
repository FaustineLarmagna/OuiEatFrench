<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\Availability;

class AvailabilityFarmerController extends Controller
{
    public function indexAction()
    {
        $farmerId = $this->get('session')->get('farmer');
        $data = null;
        if ($farmerId)
        {
            $data['farmer'] = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
            $entity = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:AvailabilityFarmer')->findOneBy(array('farmer' => $data['farmer']));
            if (!$entity)
            {
                $entity = new Availability;
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
            }
            $data['entity'] = $entity;
        }

        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:index.html.twig', $data);
    }
}