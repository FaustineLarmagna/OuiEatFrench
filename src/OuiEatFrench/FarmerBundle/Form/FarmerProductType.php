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
            ->add('unitMinimum', null, array(
                'label' => "Minimum d'unité pour la vente",
                'required' => true
                ))
            ->add('plantation', 'date', array(
                'required'  => true,
                'label' => 'Plantation (JJ/MM/AA)',
                'format'    => 'ddMMyyyy',
                'years'     => range(date('Y') -5, date('Y'))
                ))
            ->add('harvest', 'date', array(
                'label' => 'Récolte (JJ/MM/AA)',
                'required' => true,
                'format' => 'ddMMyyyy',
                'years'     => range(date('Y') -5, date('Y'))
                ))

            ->add('agricultureType', null, array(
                'label' => "Type d'agriculture",
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
            ->add('conservation', null, array(
                'label' => "Conservation",
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
