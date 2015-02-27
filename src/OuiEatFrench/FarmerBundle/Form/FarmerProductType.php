<?php

namespace OuiEatFrench\FarmerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FarmerProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', null, array(
                'label' => 'Produit',
                'required' => true
                ))
            ->add('plantation', 'date', array(
                'required'  => true,
                'format'    => 'ddMMyyyy',
                'years'     => range(date('Y') -5, date('Y'))
                ))
            ->add('harvest', 'date', array(
                'label' => 'Récolte',
                'required' => true,
                'format' => 'ddMMyyyy',
                'years'     => range(date('Y') -5, date('Y'))
                ))
            ->add('unitMinimum', null, array(
                'label' => "Minimum d'unité pour la vente",
                'required' => true
                ))
            ->add('agricultureType', null, array(
                'label' => "Type d'agriculture",
                'required' => true
                ))
            ->add('conservation', null, array(
                'required' => true
                ))
            ->add('unitPrice', null, array(
                'label' => 'Prix unitaire',
                'required' => true
                ))
            ->add('unitQuantity', null, array(
                'label' => "Quantité d'unité",
                'required' => true
                ))
            ->add('unitType', null, array(
                'label' => "Type d'unité",
                'required' => true
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OuiEatFrench\FarmerBundle\Entity\FarmerProduct'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ouieatfrench_farmerbundle_farmerproducttype';
    }
}
