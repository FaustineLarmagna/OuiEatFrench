<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\FarmerProduct;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandController extends Controller
{
    public function indexAction()
    {
        $farmer = $this->get('session')->get('farmer');
        $data['farmer'] = $farmer;

        $data['commands'] = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:Command')->findBy(array('farmer' => $farmer));
        return $this->render('OuiEatFrenchFarmerBundle:FarmerCommand:index.html.twig', $data);
    }

    public function showAction($id)
    {
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_home'));
        }

        /* here */

        return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    }

    public function editAction($id)
    {
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_home'));
        }

        /* here */

        return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    }

    public function deleteAction($id)
    {
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_public_home'));
        }

        /* here */

        return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    }
}
