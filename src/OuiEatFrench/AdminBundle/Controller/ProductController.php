<?php

namespace OuiEatFrench\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\AdminBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function ajaxAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
        {
            $name = $request->request->get('name');

            $product = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findOneByName($name);

            if($product)
            {
                return new JsonResponse(array($product->getId(), $product->getName(), $product->getDescription(), $product->getImageName()));
            }
        }
        return new JsonResponse('null');
    }

    public function indexAction()
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findAll();
        $data["entities"] = $entities;
        return $this->render('OuiEatFrenchAdminBundle:Product:index.html.twig', $data);
    }

    public function createAction()
    {
        $entity = new Product();
        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_adminbundle_producttype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $this->upload($entity->getImage());
                if($entity->getImage() !== null)
                {
                    $entity->setImageName($entity->getImage()->getClientOriginalName());
                }

                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('oui_eat_french_admin_product_index'));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_admin_product_create";
        return $this->render('OuiEatFrenchAdminBundle:Product:create.html.twig', $data);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:Product')->find($id);
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_adminbundle_producttype", $query);
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $this->upload($query->getImage());
                    if($query->getImage() !== null)
                    {
                        $image = $this->getUploadRootDir()."/".$query->getImageName();
                        if(file_exists($image) and is_file($image))
                        {
                            unlink($image);
                        }
                        $query->setImageName($query->getImage()->getClientOriginalName());
                    }
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_admin_product_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_admin_product_edit";
        }
        return $this->render('OuiEatFrenchAdminBundle:Product:edit.html.twig', $data);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:Product')->find($id);

        if ($query)
        {
            $image = $this->getUploadRootDir()."/".$query->getImageName();
            if(file_exists($image) and is_file($image))
            {
                unlink($image);
            }
            $em->remove($query);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('oui_eat_french_admin_product_index'));
    }

    public function importAction()
    {
     $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

     //on check si c'est bien un fichier csv
          if(in_array($_FILES['import-file']['type'],$mimes))
          {
            //le dossier où le fichier sera uploadé

               $dossier = $this->get('kernel')->getRootDir() . '/private/';
               $nameFile = $_FILES['import-file']['name'];
               $fichier = basename($_FILES['import-file']['name']);

               if(move_uploaded_file($_FILES['import-file']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
               {

                    //on se connecte à la DB
                    $connect = mysql_connect('localhost','root','');

                    // Si erreur
                    if (!$connect) 
                    {
                         die('Could not connect to MySQL: ' . mysql_error());
                    }

                    $cid =mysql_select_db('ouieatfrench',$connect);

                    define('CSV_PATH',$dossier);

                    $csv_file = CSV_PATH . $nameFile; // Name of your CSV file

                    $csvfile = fopen($csv_file, 'r');

                    $theData = fgets($csvfile);

                    $i = 0;

                    while (!feof($csvfile)) 
                    {

                        $csv_data[] = fgets($csvfile, 1024);

                        $csv_array = explode(";", $csv_data[$i]);

                        $insert_csv = array();

                        $insert_csv['filters'] = $csv_array[0];

                        $insert_csv['name_product'] = $csv_array[1];

                        $insert_csv['description_product'] = $csv_array[2];

                        $insert_csv['image_product'] = $csv_array[3];

                        $insert_csv['category_product'] = $csv_array[4];

                        $insert_csv['calories_product'] = $csv_array[5];

                        $categoryQuery = "SELECT DISTINCT id
                                            FROM `category`
                                            WHERE name = '".$insert_csv['category_product']."'";
                        $categoryReq = mysql_query($categoryQuery);

                        $categoryResult = mysql_result($categoryReq, 0);

                        $filtersProduct = explode('*', $insert_csv['filters']);
                        
                        

                        if (!empty($insert_csv['name_product']) && !empty($insert_csv['description_product']) && !empty($insert_csv['category_product'])) 
                        {
                            //la requete pour insert
                          $query = "INSERT INTO product(id,name,description,image_name,category_id,calories) VALUES ('', '".mysql_real_escape_string($insert_csv['name_product'])."', '".mysql_real_escape_string($insert_csv['description_product'])."', '".$insert_csv['image_product']."', '".$categoryResult."', '".$insert_csv['calories_product']."')
                          ";

                          $n = mysql_query($query, $connect) or exit(mysql_error());

                          $lastIdProduct = mysql_insert_id();
                        }

                        $i++;

                        for ($q = 0; $q < count($filtersProduct); $q++) 
                        { 
                            if (!empty($filtersProduct[$q])) 
                            {
                                $queryFilters = "INSERT INTO filter_for_product(id,name) VALUES ('', '".mysql_real_escape_string($filtersProduct[$q])."')";

                                $k = mysql_query($queryFilters, $connect) or exit(mysql_error());

                                $lastIdFilter = mysql_insert_id();

                                $queryProductFilter = "INSERT INTO product_filter(product_id,filter_id) VALUES('".$lastIdProduct."', '".$lastIdFilter."')"; 

                                $p = mysql_query($queryProductFilter, $connect) or exit(mysql_error());
                            }            
                        }     
                }
            }

            fclose($csvfile);

            mysql_close($connect);

            $entities = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findAll();
            $data["entities"] = $entities;
            return $this->render('OuiEatFrenchAdminBundle:Product:index.html.twig', $data);
        }

         else //Sinon (la fonction renvoie FALSE).
           {
                $entities = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Product')->findAll();
                $data["entities"] = $entities;
                $data["errorImport"] = "Erreur au moment de l'import, veuillez envoyer le exports-oef.csv";
                return $this->render('OuiEatFrenchAdminBundle:Product:index.html.twig', $data);
           }
    }

    public function upload($image)
    {
        if (null === $image)
        {
            return;
        }

        $name = $image->getClientOriginalName();

        $image->move($this->getUploadRootDir(), $name);

        $this->url = $name;

        $this->alt = $name;
    }

    public function getUploadDir()
    {
        return 'OEF/img_admin_product';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
}
