<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findBy(array('parentProduct' => null));
        $categories = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Category')->findAll();
        $seasons = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Season')->findAll();
        $data["products"] = $products;
        $data["categories"] = $categories;
        $data["seasons"] = $seasons;

        return $this->render('OuiEatFrenchPublicBundle:Product:index.html.twig', $data);
    }

    public function farmerProductSelectedAction($productId)
    {
        $farmers = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findFarmerByProductAndParent($productId);

        $productAndParentProduct = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findProductAndChildProduct($productId);


        return $this->render('OuiEatFrenchPublicBundle:Product:farmer_product_selected.html.twig',
            array(
                'farmers' => $farmers,
                'productAndParentProduct' => $productAndParentProduct,
                'product_id' => $productId
            ));
    }
}
