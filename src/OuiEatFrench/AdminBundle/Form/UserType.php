<?php

namespace OuiEatFrench\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                'label'     => 'Nom d\'utilisateur',
                'required'   => true
            ))
            ->add('email', null, array(
                'label'     => 'Email',
                'required'   => true
            ))
            ->add('password', 'password', array(
                'label'     => 'Mot de passe',
                'required'   => true
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OuiEatFrench\AdminBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'ouieatfrench_adminbundle_usertype';
    }
}
