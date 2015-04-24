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
        if (!$farmer || is_string($farmer)) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
        }
        $data['farmer'] = $farmer;

        $data['commands'] = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:Command')->findBy(array('farmer' => $farmer));
        return $this->render('OuiEatFrenchFarmerBundle:FarmerCommand:index.html.twig', $data);
    }

    public function readyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer || is_string($farmer)) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
        }

        $command = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->find($id);
        if (!$command || $command->getFarmer()->getId() != $farmer->getId()) {
            $this->get('session')->getFlashBag()->add('error', "Action invalide.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
        }

        $status = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('ready');
        $command->setStatus($status);

        $em->flush();
        $this->get('session')->getFlashBag()->add('info', "Le statut de commande a bien été modifié.");

        return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    }

    public function closedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer || is_string($farmer)) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
        }

        $command = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->find($id);
        if (!$command || $command->getFarmer()->getId() != $farmer->getId()) {
            $this->get('session')->getFlashBag()->add('error', "Action invalide.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
        }

        $status = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('closed');
        $command->setStatus($status);

        $em->flush();
        $this->get('session')->getFlashBag()->add('info', "Le statut de commande a bien été modifié.");

        return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    }

    // public function deleteAction($id)
    // {
    //     $farmer = $this->get('session')->get('farmer');
    //     if (!$farmer) {
    //         $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
    //         return $this->redirect($this->generateUrl('oui_eat_french_public_home'));
    //     }

    //     /* here */

    //     return $this->redirect($this->generateUrl('oui_eat_french_farmer_command_index'));
    // }
}
