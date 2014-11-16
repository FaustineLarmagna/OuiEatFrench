<?php

namespace OuiEatFrench\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationController extends Controller
{
    public function indexAction()
    {
        $farmers = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findAll();
        $data["farmers"] = $farmers;
        return $this->render('OuiEatFrenchAdminBundle:Application:index.html.twig', $data);
    }

    public function toReviewAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($id);
        if($query)
        {
        	$status = $em->getRepository('OuiEatFrenchAdminBundle:UserFarmerStatus')->find(1);
            $query->setStatus($status);
            $em->persist($query);
            $em->flush();
        }
        return $this->indexAction();
    }

    public function missingDocAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($id);
        if($query)
        {
        	$status = $em->getRepository('OuiEatFrenchAdminBundle:UserFarmerStatus')->find(2);
            $query->setStatus($status);
            $em->persist($query);
            $em->flush();
        }
        return $this->indexAction();
    }

    public function validateAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($id);
        if($query)
        {
        	$status = $em->getRepository('OuiEatFrenchAdminBundle:UserFarmerStatus')->find(3);
            $query->setStatus($status);
            $em->persist($query);
            $em->flush();
        }
        return $this->indexAction();
    }

    public function banAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($id);
        if($query)
        {
        	$status = $em->getRepository('OuiEatFrenchAdminBundle:UserFarmerStatus')->find(4);
            $query->setStatus($status);
            $em->persist($query);
            $em->flush();
        }
        return $this->indexAction();
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($id);
        if($query)
        {
            $data["farmer"] = $query;
        }
        return $this->render('OuiEatFrenchAdminBundle:Application:show.html.twig', $data);
    }
}
