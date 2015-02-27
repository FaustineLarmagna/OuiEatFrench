<?php

namespace OuiEatFrench\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', 'password', array(
                "label"     => "Ancien mot de passe",
                "required"   => true
            ))
            ->add('newpassword', 'password', array(
                "label"     => "Nouveau mot de passe",
                "required"   => true
            ))
            ->add('confirmpassword', 'password', array(
                "label"     => "Confirmation nouveau mot de passe",
                "required"   => true
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    public function getName()
    {
        return 'ouieatfrench_userbundle_changepasswordtype';
    }
}

?>
