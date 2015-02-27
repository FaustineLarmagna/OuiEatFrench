<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\FarmerProduct;

class FarmerProductController extends Controller
{
    public function indexAction($farmerId)
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        $farmerproducts = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->findBy(array('farmer' => $farmer));
        $data["farmerproducts"] = $farmerproducts;
        $data['farmer'] = $farmer;
        
        return $this->render('OuiEatFrenchFarmerBundle:FarmerProduct:index.html.twig', $data);
    }

    public function addAction($farmerId)
    {
        $em = $this->getDoctrine()->getManager();
    	$farmer = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        $entity = new FarmerProduct();
        $entity->setFarmer($farmer);
        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_farmerbundle_farmerproducttype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                if ($entity->getUnitMinimum() >= $entity->getUnitQuantity()) {
                    $entity->setSelling(1);
                }

                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('oui_eat_french_farmer_product_index', array('farmerId' => $farmerId)));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_farmer_product_add";
        $data["farmer"] = $farmer;
        return $this->render('OuiEatFrenchFarmerBundle:FarmerProduct:add.html.twig', $data);
    }

    public function editAction($farmerId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        //$user = $this->get('security.context')->getToken()->getUser();
        $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);

        // if ($user != $farmer || $user != $query->getFarmer()) {
        //     $this->get('session')->getFlashBag()->add('warning', "Vous ne pouvez pas modifier ce produit.");

        //     return $this->redirect($this->generateUrl('oui_eat_french_farmer_product_index', array('farmerId' => $user->getId())));
        // }
        
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_farmerbundle_farmerproducttype", $query);
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
            $data["farmer"] = $farmer;
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
