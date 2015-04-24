<?php

namespace OuiEatFrench\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\AdminBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class UserController extends Controller
{
    public function logoutAction()
    {
        $this->container->get('security.context')->setToken(null);
        return $this->redirect($this->generateUrl('oui_eat_french_admin_user_login'));
    }

    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('OuiEatFrenchAdminBundle:User:login.html.twig', array(
            'last_username'    => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
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
                $password = $entity->getPassword();
                $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
                $encodedPass = $encoder->encodePassword($password, $entity->getSalt());
                $entity->setPassword($encodedPass);

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
