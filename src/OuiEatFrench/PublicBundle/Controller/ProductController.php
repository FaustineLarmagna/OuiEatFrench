<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findBy(array('parentProduct' => null));
        $data["products"] = $products;

        return $this->render('OuiEatFrenchPublicBundle:Product:index.html.twig', $data);
    }

    public function farmerProductSelectedAction($product_id)
    {
        $farmers = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findFarmerByProductAndParent($product_id);

        $productAndParentProduct = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findProductAndChildProduct($product_id);


        return $this->render('OuiEatFrenchPublicBundle:Product:farmer_product_selected.html.twig',
            array(
                'farmers' => $farmers,
                'productAndParentProduct' => $productAndParentProduct,
                'product_id' => $product_id
            ));
    }
}
