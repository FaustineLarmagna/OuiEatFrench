<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\FarmerProduct;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandController extends Controller
{
    public function indexAction($farmerId)
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findAll();
        $data["entities"] = $entities;
        $data['farmer'] = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find(1);//$this->get('security.context')->getToken()->getUser();
        $data['commands'] = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:Command')->findBy(array('farmer' => $data['farmer']));
        return $this->render('OuiEatFrenchFarmerBundle:FarmerCommand:index.html.twig', $data);
    }
}
