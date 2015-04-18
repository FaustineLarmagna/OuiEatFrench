<?php

namespace OuiEatFrench\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\AdminBundle\Entity\User;

class UserController extends Controller
{
    public function logoutAction()
    {
        $this->get('session')->remove('admin');
        return $this->redirect($this->generateUrl('oui_eat_french_admin_user_login'));
    }

    public function loginAction()
    {
        $parameters = array();

        $request = $this->get('request');

        $email = $request->get('email');
        $password = $request->get('password');

        if ($request->getMethod() == 'POST')
        {
            if ($email == '' or $password == '')
            {
                $parameters['error'] = 'Champs manquants';
            }
            else
            {
                $password = sha1($password);
                $user = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:User')->findOneBy(array('email' => $email, 'password' => $password));

                if ($user)
                {
                    $this->get('session')->set('admin', $email);
                    return $this->redirect($this->generateUrl('oui_eat_french_admin'));
                }
                $parameters['error'] = 'Indentifiants ou mot de passe incorrect';
            }
        }

        return $this->render('OuiEatFrenchAdminBundle:User:login.html.twig', $parameters);
    }

    public function indexAction()
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchAdminBundle:User')->findAll();
        $data["entities"] = $entities;
        return $this->render('OuiEatFrenchAdminBundle:User:index.html.twig', $data);
    }

    public function createAction()
    {
        $entity = new User();
        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_adminbundle_usertype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('oui_eat_french_admin_user_index'));
            }
        }
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_admin_user_create";
        return $this->render('OuiEatFrenchAdminBundle:User:create.html.twig', $data);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:User')->find($id);
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_adminbundle_usertype", $query);
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_admin_user_index'));
                }
            }
            $data["id"] = $id;
            $data["form"] = $form->createView();
            $data["route"] = "oui_eat_french_admin_user_edit";
        }
        return $this->render('OuiEatFrenchAdminBundle:User:edit.html.twig', $data);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchAdminBundle:User')->find($id);

        if ($query)
        {
            $em->remove($query);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('oui_eat_french_admin_user_index'));
    }
}
