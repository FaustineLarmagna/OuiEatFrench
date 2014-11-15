<?php

namespace OuiEatFrench\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\AdminBundle\Entity\Edito;

class EditoController extends Controller
{
    public function disableAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:Edito')->find($id);
        if($query)
        {
            $query->setDisable(!$query->getDisable());
            $em->persist($query);
            $em->flush();
        }
        return $this->indexAction();
    }

    public function indexAction()
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:Edito')->findAll();
        $data["entities"] = $entities;
        return $this->render('OuiEatFrenchAdminBundle:Edito:index.html.twig', $data);
    }

    public function createAction()
    {
        $entity = new Edito();
        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_adminbundle_editotype", $entity);
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
                return $this->redirect($this->generateUrl('oui_eat_french_admin_edito_index'));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_admin_edito_create";
        return $this->render('OuiEatFrenchAdminBundle:Edito:create.html.twig', $data);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:Edito')->find($id);
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_adminbundle_editotype", $query);
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $this->upload($query->getImage());
                    if($query->getImage() !== null)
                    {
                        if(file_exists($this->getUploadRootDir()."/".$query->getImageName()))
                        {
                            unlink($this->getUploadRootDir()."/".$query->getImageName());
                        }
                        $query->setImageName($query->getImage()->getClientOriginalName());
                    }
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_admin_edito_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_admin_edito_edit";
        }
        return $this->render('OuiEatFrenchAdminBundle:Edito:edit.html.twig', $data);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:Edito')->find($id);

        if ($query)
        {
            if(file_exists($this->getUploadRootDir()."/".$query->getImageName()))
            {
                unlink($this->getUploadRootDir()."/".$query->getImageName());
            }
            $em->remove($query);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('oui_eat_french_admin_edito_index'));
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
        return 'OEF/img_admin_edito';
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
