<?php

namespace OuiEatFrench\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction($page = 1)
    {
        $filters = $this->searchByFilter();

        $products = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findByParentNullAndLimitPage($page, 16, $filters);
        $productsSelect = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findBy(array('parentProduct' => null));
        $numberProducts = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findByParentNull($filters);

        $categories = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Category')->findAll();
        $seasons = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Season')->findAll();

        $data["page"] = $page;
        $data["pagesNumber"] = ceil(count($numberProducts)/16);
        $data["productsSelect"] = $productsSelect;
        $data["products"] = $products;
        $data["categories"] = $categories;
        $data["seasons"] = $seasons;

        return $this->render('OuiEatFrenchPublicBundle:Product:index.html.twig', $data);
    }

    public function searchByFilter()
    {
        $request = $this->getRequest();
        $name = $request->request->get('name');
        $season = $request->request->get('season');
        $calories = $request->request->get('calories');
        $category = $request->request->get('category');

        if (!$name and !$season and !$calories and !$category)
        {
            $filters = $this->get('session')->get('filters');
            $name = $filters['name'];
            $season = $filters['season'];
            $calories = $filters['calories'];
            $category = $filters['category'];
        }
        else
        {
            $this->get('session')->set('filters', array('name' => $name, 'season' => $season, 'calories' => $calories, 'category' => $category));
        }

        $products = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findAll();
        $idProducts = array();
        foreach($products as $product)
            $idProducts[] = $product->getId();

        $table = array();
        if($name != 'all')
        {
            $table['name'] = $name;
            $productsByName = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findBy($table);

            $idProductsByName = array();
            foreach($productsByName as $productByName)
                $idProductsByName[] = $productByName->getId();

            $merge = array();
            foreach($idProductsByName as $value)
            {
                if(in_array($value, $idProducts))
                {
                    $merge[$value] = $value;
                }
            }
            $idProducts = $merge;
        }

        if($season != 'all')
        {
            $productsBySeason = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findAllProductBySeason($season);
            $idProductsBySeason = array();
            foreach($productsBySeason as $productBySeason)
                $idProductsBySeason[] = $productBySeason->getId();

            $merge = array();
            foreach($idProductsBySeason as $value)
            {
                if(in_array($value, $idProducts))
                {
                    $merge[] = $value;
                }
            }
            $idProducts = $merge;
        }

        if($calories != 0)
        {
            $productsByCalories = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findAllProductByCalories($calories);
            $idProductsByCalories = array();
            foreach($productsByCalories as $productByCalories)
                $idProductsByCalories[] = $productByCalories->getId();

            $merge = array();
            foreach($idProductsByCalories as $value)
            {
                if(in_array($value, $idProducts))
                {
                    $merge[] = $value;
                }
            }
            $idProducts = $merge;
        }

        if($category != 'all')
        {
            $category = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Category')->findByName($category);
            $productsByCategory = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findByCategory($category);
            $idProductsByCategory = array();
            foreach($productsByCategory as $productByCategory)
                $idProductsByCategory[] = $productByCategory->getId();

            $merge = array();
            foreach($idProductsByCategory as $value)
            {
                if(in_array($value, $idProducts))
                {
                    $merge[] = $value;
                }
            }
            $idProducts = $merge;
        }

        if (empty($idProducts))
        {
            $idProducts = array(0);
        }

        return $idProducts;
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
