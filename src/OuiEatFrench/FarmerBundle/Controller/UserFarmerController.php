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
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else
        {
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
        $em = $this->getDoctrine()->getManager();
        $farmer = $this->get('security.context')->getToken()->getUser();
        $paidStatus = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('paid');
        $readyStatus = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('ready');
        $closedStatus = $em->getRepository('OuiEatFrenchAdminBundle:CommandStatus')->findOneByName('closed');
        $data['farmer'] = $farmer;
        $data['commands_inprogress'] = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->getCommandsInProgress($farmer, $paidStatus, $readyStatus);
        $data['commands_closed'] = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->findBy(array(
            'farmer' => $farmer,
            'status' => $closedStatus
        ));

        $myBestSells = $this->getMyBestSells($farmer, $data['commands_closed']);
        $allBestSells = $this->getAllBestSells($em);

        $data['total_benefice'] = $myBestSells['benefice'];
        $data['my_best_sells'] = $myBestSells['best_sells'];
        $data['all_best_sells'] = $allBestSells;

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

    private function getMyBestSells($farmer, $commands) {
        $totalBenefice = 0;
        $bestSells = array();
        foreach ($commands as $command) {
            foreach ($command->getCart()->getFarmerProductCarts() as $productCart) {
                if ($productCart->getFarmerProduct()->getFarmer()->getId() == $farmer->getId()) {
                    $product = $productCart->getFarmerProduct()->getProduct();
                    $productId = $product->getId();
                    $totalBenefice += ($productCart->getFarmerProduct()->getUnitPrice() * $productCart->getUnitQuantity());
                    if (array_key_exists($productId, $bestSells)) {
                        $bestSells[$productId]['quantity'] += $productCart->getUnitQuantity();
                    } else {
                        $bestSells[$productId]['quantity'] = $productCart->getUnitQuantity();
                        $bestSells[$productId]['product'] = $product;
                    }
                }
            }
        }

        if (count($bestSells) > 4) {
            $reducedBestSells = array();
            while (count($reducedBestSells) < 4) {
                $max = 0;
                $id = 0;
                $product = 0;
                foreach($bestSells as $productId => $array) {
                    if ($max !== 0 && $array['quantity'] > $max) {
                        $max = $array['quantity'];
                        $id = $productId;
                        $product = $array['product'];
                    } elseif ($max === 0) {
                        $max = $array['quantity'];
                        $id = $productId;
                        $product = $array['product'];
                    }
                }
                $reducedBestSells[$id]['quantity'] = $max;
                $reducedBestSells[$id]['product'] = $product;
                unset($bestSells[$id]);
            }
            $bestSells = $reducedBestSells;
        }

        return array('benefice' => $totalBenefice, 'best_sells' => $bestSells);
    }

    private function getAllBestSells($em) {
        $commands = $em->getRepository('OuiEatFrenchFarmerBundle:Command')->findAll();
        $bestSells = array();
        foreach ($commands as $command) {
            foreach ($command->getCart()->getFarmerProductCarts() as $productCart) {
                $product = $productCart->getFarmerProduct()->getProduct();
                $productId = $product->getId();
                if (array_key_exists($productId, $bestSells)) {
                    $bestSells[$productId]['quantity'] += $productCart->getUnitQuantity();
                } else {
                    $bestSells[$productId]['quantity'] = $productCart->getUnitQuantity();
                    $bestSells[$productId]['product'] = $product;
                }
            }
        }

        if (count($bestSells) > 4) {
            $reducedBestSells = array();
            while (count($reducedBestSells) < 4) {
                $max = 0;
                $id = 0;
                $product = 0;
                foreach($bestSells as $productId => $array) {
                    if ($max !== 0 && $array['quantity'] > $max) {
                        $max = $array['quantity'];
                        $id = $productId;
                        $product = $array['product'];
                    } elseif ($max === 0) {
                        $max = $array['quantity'];
                        $id = $productId;
                        $product = $array['product'];
                    }
                }
                $reducedBestSells[$id]['quantity'] = $max;
                $reducedBestSells[$id]['product'] = $product;
                unset($bestSells[$id]);
            }
            $bestSells = $reducedBestSells;
        }

        return $bestSells;
    }
}