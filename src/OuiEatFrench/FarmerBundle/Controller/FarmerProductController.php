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

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $farmerId = $this->get('session')->get('farmer');
        $farmer = $em->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->find($farmerId);
        $farmerproducts = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->findBy(array('farmer' => $farmer));
        $data["farmerproducts"] = $farmerproducts;
        $data['farmer'] = $farmer;
        
        return $this->render('OuiEatFrenchFarmerBundle:FarmerProduct:index.html.twig', $data);
    }

    public function addAction()
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer || is_string($farmer)) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
        }

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
                return $this->redirect($this->generateUrl('oui_eat_french_farmer_product_index', array('farmerId' => $farmer->getId())));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_farmer_product_add";
        $data["farmer"] = $farmer;
        return $this->render('OuiEatFrenchFarmerBundle:FarmerProduct:add.html.twig', $data);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer || is_string($farmer)) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
        }

        $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);
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

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('session')->get('farmer');
        if (!$farmer || is_string($farmer)) {
            $this->get('session')->getFlashBag()->add('error', "Vous ne pouvez pas accéder cet élément.");
            return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
        }

        $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);
        if ($query)
        {
            $em->remove($query);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('oui_eat_french_farmer_stock_index'));
    }
}
