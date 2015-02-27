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

    public function registerAction()
    {
        $entity = new UserFarmer();

        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_farmerbundle_userfarmershorttype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                $status = $em->getRepository('OuiEatFrenchAdminBundle:UserFarmerStatus')->find(1);
                $entity->setStatus($status);

                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_index'));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_farmer_user_register";
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:register.html.twig', $data);
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
                    if($query->getFileAvatar() !== null) {
                        $this->upload($query->getFileAvatar(), $query);
                        $query->setAvatar($query->getFileAvatar()->getClientOriginalName());
                    }

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_farmer_user_edit";
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
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:profil.html.twig', $data);
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
        return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_index'));
    }

    public function upload($image, $entity)
    {
        if (null === $image) {
            return;
        }

        $name = $image->getClientOriginalName();
        $image->move($entity->getUploadRootDir(), $name);
    }
}