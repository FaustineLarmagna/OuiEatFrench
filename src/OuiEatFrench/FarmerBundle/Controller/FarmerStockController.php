<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\FarmerProduct;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FarmerStockController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('security.context')->getToken()->getUser();

        $farmerproducts = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->findBy(array('farmer' => $farmer));
        $data["farmerproducts"] = $farmerproducts;
        $data['farmer'] = $farmer;
        
        return $this->render('OuiEatFrenchFarmerBundle:FarmerStock:index.html.twig', $data);
    }

    public function deleteAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();

            $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);
            if ($query)
            {
                $em->remove($query);
                $em->flush();
            }
            return new JsonResponse($id);
        }
       
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();

            $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);
            if ($query)
            {
                $newQuantity = $query->getUnitQuantity() + 1;
                $query->setUnitQuantity($newQuantity);
                $em->flush();

                return new JsonResponse($newQuantity);
            }
            return new JsonResponse('null');
        }
    }

    public function removeAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();

            $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);
            if ($query)
            {
                $newQuantity = $query->getUnitQuantity() - 1;
                if ($newQuantity < 0) {
                    return new JsonResponse(0);
                }
                $query->setUnitQuantity($newQuantity);
                $em->flush();

                return new JsonResponse($newQuantity);
            }
            return new JsonResponse('null');
        }
    }

    public function adjustAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $stock = $request->request->get('stock');
            $em = $this->getDoctrine()->getManager();

            $query = $em->getRepository('OuiEatFrenchFarmerBundle:FarmerProduct')->find($id);
            if ($query)
            {
                $query->setUnitQuantity($stock);
                $em->flush();

                return new JsonResponse($stock);
            }
            return new JsonResponse('null');
        }
    }
}
