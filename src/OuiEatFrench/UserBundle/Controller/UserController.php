<?php

namespace OuiEatFrench\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function editAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('OuiEatFrenchUserBundle:User')->find($id);
        if($query)
        {
            $request = $this->get("request");
            $form = $this->createForm("ouieatfrench_userbundle_changepasswordtype");
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($query);
                    $em->flush();
                    return $this->redirect($this->generateUrl('oui_eat_french_admin_category_index'));
                }
            }
            $data["id"] = $id;
            $data["formPassword"] = $form->createView();
            $data["route"] = "oui_eat_french_user_password_edit";
        }
        return $this->render('OuiEatFrenchUserBundle:Profile:edit.html.twig', $data);
    }
}
