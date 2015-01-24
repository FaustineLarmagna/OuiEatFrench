<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\FarmerProduct;

class FarmerProductController extends Controller
{
    public function indexAction($farmerId)
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findAll();
        $data["products"] = $entities;
        $data['farmer'] = $farmerId;
        //$data['farmer'] = $this->get('security.context')->getToken()->getUser();
        
        return $this->render('OuiEatFrenchFarmerBundle:FarmerProduct:index.html.twig', $data);
    }

    public function addAction($farmerId, $id)
    {
    	$user = $this->get('security.context')->getToken()->getUser();
        $entity = new FarmerProduct();
        $entity->setIdFarmer($user->getId());
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
                return $this->redirect($this->generateUrl('oui_eat_french_farmer_product_index'));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_farmer_product_create";
        return $this->render('OuiEatFrenchFarmerBundle:FarmerProduct:create.html.twig', $data);
    }

    public function editAction($farmerId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);
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
                    return $this->redirect($this->generateUrl('oui_eat_french_farmer_product_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_farmer_product_edit";
        }
        return $this->render('OuiEatFrenchFarmerBundle:FarmerProduct:edit.html.twig', $data);
    }

    public function deleteAction($farmerId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);

        if ($query)
        {
            $em->remove($query);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('oui_eat_french_farmer_product_index'));
    }
}
