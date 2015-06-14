<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\FarmerProduct;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('security.context')->getToken()->getUser();
        $paidStatus = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('paid');
        $readyStatus = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('ready');
        $closedStatus = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('closed');
        $data['farmer'] = $farmer;
        $data['commands_inprogress'] = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->getCommandsInProgress($farmer, $paidStatus, $readyStatus);
        $data['commands_closed'] = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->findBy(array(
            'farmer' => $farmer,
            'status' => $closedStatus
        ));

        return $this->render('OuiEatFrenchFarmerBundle:FarmerCommand:index.html.twig', $data);
    }

    public function readyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('security.context')->getToken()->getUser();

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
        $farmer = $this->get('security.context')->getToken()->getUser();

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
