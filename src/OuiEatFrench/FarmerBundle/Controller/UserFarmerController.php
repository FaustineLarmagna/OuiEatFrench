<?php

namespace OuiEatFrench\FarmerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OuiEatFrench\FarmerBundle\Entity\UserFarmer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class UserFarmerController extends Controller
{
    public function logoutAction()
    {
        $this->container->get('security.context')->setToken(null);
        return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_login'));
    }

    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        //Register form
        $entity = new UserFarmer();
        $form = $this->createForm("ouieatfrench_farmerbundle_userfarmershorttype", $entity);

        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:register.html.twig', array(
            // Valeur du précédent nom d'utilisateur entré par l'internaute
            'last_email'    => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'form'          => $form->createView(),
        ));
    }

    public function indexAction()
    {
        $entities = $this->getDoctrine()->getRepository('OuiEatFrenchFarmerBundle:UserFarmer')->findAll();
        $data["entities"] = $entities;
        $data['farmer'] = $this->get('security.context')->getToken()->getUser();

        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:index.html.twig', $data);
    }

    public function registerAction()
    {
        $entity = new UserFarmer();

        $request = $this->get("request");
        $form = $this->createForm("ouieatfrench_farmerbundle_userfarmershorttype", $entity);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                $password = $entity->getPassword();
                $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
                $encodedPass = $encoder->encodePassword($password, $entity->getSalt());
                $entity->setPassword($encodedPass);
                $status = $em->getRepository('OuiEatFrenchAdminBundle:UserFarmerStatus')->findOneByName('to_review');
                $entity->setStatus($status);

                $em->persist($entity);
                $em->flush();
                $this->get('session')->set('farmer', $entity);
            }
        }
        $data["form"] = $form->createView();
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:register.html.twig', $data);
    }

    public function editAction()
    {
        $request = $this->get("request");
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm("ouieatfrench_farmerbundle_userfarmertype", $user);
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                if($user->getFileAvatar() !== null) {
                    $this->upload($user->getFileAvatar(), $user);
                    $user->setAvatar($user->getFileAvatar()->getClientOriginalName());
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_index'));
            }
        }
        $data["id"] = $user->getId();
        $data["form"] = $form->createView();
        $data["route"] = "oui_eat_french_farmer_user_edit";
        
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:edit.html.twig', $data);
    }

    public function showAction()
    {
        $data["farmer"] = $this->get('security.context')->getToken()->getUser();
        return $this->render('OuiEatFrenchFarmerBundle:UserFarmer:profil.html.twig', $data);
    }

    public function deleteAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        
        return $this->redirect($this->generateUrl('oui_eat_french_farmer_user_index'));
    }

    public function upload($image, $entity)
    {
        if (null === $image) {
            return;
        }

        $name = $image->getClientOriginalName();
        $image->move($entity->getUploadRootDir(), $name);
    }
}