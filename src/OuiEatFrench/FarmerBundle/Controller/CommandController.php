<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\FarmerProduct;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandController extends Controller
{
    public function indexAction()
    {
        $farmerId = $this->get('session')->get('farmer');
        $farmer = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findAll();
        $data["entities"] = $entities;
        $data['farmer'] = $farmer;
        $data['commands'] = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:Command')->findBy(array('farmer' => $data['farmer']));
        return $this->render('OuiEatFrenchFarmerBundle:FarmerCommand:index.html.twig', $data);
    }

    public function showAction($id)
    {
        $farmerId = $this->get('session')->get('farmer');
        $farmer = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        if (!$farmer) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas voir cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_home'));
        }

        /* here */

        return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    }

    public function editAction($id)
    {
        $farmerId = $this->get('session')->get('farmer');
        $farmer = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        if (!$farmer) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas voir cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_home'));
        }

        /* here */

        return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    }

    public function deleteAction($id)
    {
        $farmerId = $this->get('session')->get('farmer');
        $farmer = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        if (!$farmer) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas voir cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_home'));
        }

        /* here */

        return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    }
}
