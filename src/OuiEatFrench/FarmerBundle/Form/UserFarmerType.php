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
            ->add('email', 'email')
            ->add('password', null, array('label' => 'Mot de passe'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('birthday', 'date', array(
                'label'     => 'Date de naissance',
                'format'    => 'dd MM yyyy',
                'years'     => range($year, $year-100)
            ))
            ->add('street', null, array('label' => 'Adresse personnelle'))
            ->add('postcode', null, array('label' => 'Code postal'))
            ->add('city', null, array('label' => 'Ville'))
            ->add('phone', null, array('label' => 'Numéro de téléphone'))
            ->add('companyName', null, array('label' => "Nom de l'exploitation"))
            ->add('companyStreet', null, array('label'     => "Adresse de l'exploitation"))
            ->add('companyPostcode', null, array('label'     => "Code postal"))
            ->add('companyCity', null, array('label'     => "Ville"))
            ->add('avatar', null, array(
                'required'  => false
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
        return 'ouieatfrench_farmerbundle_userfarmertype';
    }
}
