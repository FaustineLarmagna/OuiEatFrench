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

    public function readyAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $farmer = $this->get('security.context')->getToken()->getUser();

            $command = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->find($id);
            if (!$command || $command->getFarmer()->getId() != $farmer->getId()) {
                return new JsonResponse(false);
            }

            $status = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('ready');
            $command->setStatus($status);

            $em->flush();

            return new JsonResponse($id);
        }
        
        return new JsonResponse(false);
    }

    public function closedAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $farmer = $this->get('security.context')->getToken()->getUser();

            $command = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->find($id);
            if (!$command || $command->getFarmer()->getId() != $farmer->getId()) {
                return new JsonResponse(false);
            }

            $status = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('closed');
            $command->setStatus($status);

            $em->flush();

            return new JsonResponse($id);
        }
        
        return new JsonResponse(false);
    }
}
