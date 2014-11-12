<?php

namespace OuiEatFrench\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\CommandBundle\Entity\CommandStatus;

class CommandStatusController extends Controller
{
    public function indexAction()
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchCommandBundle:CommandStatus')->findAll();
        $data["entities"] = $entities;
        return $this->render('OuiEatFrenchCommandBundle:CommandStatus:index.html.twig', $data);
    }

    public function createAction()
    {
        $entity = new CommandStatus();
        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_commandbundle_commandstatustype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('oui_eat_french_command_commandstatus_index'));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_command_commandstatus_create";
        return $this->render('OuiEatFrenchCommandBundle:CommandStatus:create.html.twig', $data);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchCommandBundle:CommandStatus')->find($id);
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_commandbundle_commandstatustype", $query);
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_command_commandstatus_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_command_commandstatus_edit";
        }
        return $this->render('OuiEatFrenchCommandBundle:CommandStatus:edit.html.twig', $data);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchCommandBundle:CommandStatus')->find($id);

        if ($query)
        {
            $em->remove($query);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('oui_eat_french_command_commandstatus_index'));
    }
}
