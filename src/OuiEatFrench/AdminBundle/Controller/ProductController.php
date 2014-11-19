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
