<?php

namespace OuiEatFrench\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\AdminBundle\Entity\UnitType;

class UnitTypeController extends Controller
{
    public function indexAction()
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:UnitType')->findAll();
        $data["entities"] = $entities;
        return $this->render('OuiEatFrenchAdminBundle:UnitType:index.html.twig', $data);
    }

    public function createAction()
    {
        $entity = new UnitType();
        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_adminbundle_unittypetype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('oui_eat_french_admin_unittype_index'));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_admin_unittype_create";
        return $this->render('OuiEatFrenchAdminBundle:UnitType:create.html.twig', $data);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:UnitType')->find($id);
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_adminbundle_unittypetype", $query);
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_admin_unittype_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_admin_unittype_edit";
        }
        return $this->render('OuiEatFrenchAdminBundle:UnitType:edit.html.twig', $data);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:UnitType')->find($id);

        if ($query)
        {
            $em->remove($query);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('oui_eat_french_admin_unittype_index'));
    }
}
