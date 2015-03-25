<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\FarmerProduct;
use Symfony\Component\HttpFoundation\JsonResponse;

class FarmerProductController extends Controller
{
    public function ajaxFarmerAction()
    {
        //return new JsonResponse('test');
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            /*
            $productId = 1; //Fruits
            $companyPostCode = '77590';
            $parameters = array(
                'kilo'      =>  '1',
                'unitée'   => '1'
            );*/
            $productId = $request->request->get('product');
            $companyPostCode = $request->request->get('companyPostCode');
            $parameters = $request->request->get('parameters');
            $farmerProductsFilter = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->findFarmerProductByFilters($productId, $companyPostCode);

            $productSelected = array();
            foreach ($farmerProductsFilter as $farmerProduct)
            {
                foreach ($parameters[0] as $value)
                {
                    if ($value[1] == "")
                    {
                        $value[1] = 1000;
                    }
                    if ($farmerProduct->getUnitType()->getName() == $value[0] and $farmerProduct->getUnitPrice() <= $value[1])
                    {
                        $productSelected[] = $farmerProduct->getId();
                        break;
                    }
                }
            }

            return new JsonResponse(json_encode($productSelected));
        }
        return new JsonResponse();
    }

    public function indexAction($farmerId)
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        // $farmer = $this->get('security.context')->getToken()->getUser();
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
