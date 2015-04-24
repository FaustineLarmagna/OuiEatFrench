<?php

namespace OuiEatFrench\FarmerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFarmerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = getdate();
        $year = $date['year'] - 18;

        $builder
            ->add('username', null, array('label' => 'Nom d\'utilisateur'))
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('birthday', 'date', array(
                'label'     => 'Date de naissance',
                'format'    => 'dd MM yyyy',
                'years'     => range($year, $year-100),
                'required'  => false
            ))
            ->add('email', 'email')
            ->add('phone', null, array(
                'label' => 'Numéro de téléphone',
                'required'  => false,
            ))
            ->add('street', null, array(
                'label' => 'Adresse personnelle',
                'required'  => false,
            ))
            ->add('postcode', null, array(
                'label' => 'Code postal',
                'required'  => false,
            ))
            ->add('city', null, array(
                'label' => 'Ville',
                'required'  => false,
            ))
            ->add('companyName', null, array(
                'label' => "Nom de l'exploitation",
                'required'  => false,
            ))
            ->add('companyStreet', null, array(
                'label'     => "Adresse de l'exploitation",
                'required'  => false,
            ))
            ->add('companyPostcode', null, array(
                'label'     => "Code postal",
                'required'  => false,
            ))
            ->add('companyCity', null, array(
                'label'     => "Ville",
                'required'  => false,
            ))
            ->add('fileAvatar', 'file', array(
                'required'  => false,
                'label'     => 'Avatar'
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
    public function getParent()
    {
        return 'fos_user_registration';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ouieatfrench_farmerbundle_userfarmertype';
    }
}
