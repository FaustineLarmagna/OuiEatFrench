<?php

namespace OuiEatFrench\FarmerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFarmerShortType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('attr' => array('placeholder' => 'Nom d\'utilisateur'), 'label' => false))
            ->add('lastname', null, array('attr' => array('placeholder' => 'Nom'), 'label' => false))
            ->add('firstname', null, array('attr' => array('placeholder' => 'Prénom'), 'label' => false))
            ->add('email', 'email', array('attr' => array('placeholder' => 'Email'), 'label' => false))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('attr' => array('placeholder' => 'Mot de passe'), 'label' => false),
                'second_options' => array('attr' => array('placeholder' => 'Confirmation de mot de passe'), 'label' => false),
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OuiEatFrench\FarmerBundle\Entity\UserFarmer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ouieatfrench_farmerbundle_userfarmershorttype';
    }
}
