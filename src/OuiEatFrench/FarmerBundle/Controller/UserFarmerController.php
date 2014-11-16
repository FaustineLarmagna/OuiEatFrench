<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\UserFarmer;

class UserFarmerController extends Controller
{
    public function indexAction()
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findAll();
        $data["entities"] = $entities;
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:index.html.twig', $data);
    }

    public function createAction()
    {
        $entity = new UserFarmer();
        $entity->setStatus(1);
        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_farmerbundle_userfarmertype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('oui_eat_french_user_farmer_index'));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_user_farmer_create";
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:create.html.twig', $data);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($id);
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_farmerbundle_userfarmertype", $query);
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_user_farmer_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_user_farmer_edit";
        }
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:edit.html.twig', $data);
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($id);
        if($query)
        {
            $data["farmer"] = $query;
        }
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:show.html.twig', $data);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($id);

        if ($query)
        {
            $em->remove($query);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('oui_eat_french_user_farmer_index'));
    }
}

