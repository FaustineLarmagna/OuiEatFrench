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
            /*->add('idFarmer', 'integer', array(
                "label"     => "Producteur"
                "required"  => true
            ))*/
            ->add('idProduct', 'integer', array(
                "label"     => 'Produit',
                "class"     => 'OuiEatFrench\AdminBundle\Entity\Product',
                "required"  => true
            ))
            ->add('unitPrice', 'integer', array(
                "label"     => "Prix à l'unité",
                "required"  => true
            ))
            ->add('kiloPrice', 'integer', array(
                "label"     => "Prix au kilo",
                "required"  => true
            ))
            ->add('unitQuantity', 'integer', array(
                "label"     => "Quantité d'unité",
                "required"  => true
            ))
            ->add('kiloQuantity', 'integer', array(
                "label"     => "Quantité de kilo",
                "required"  => true
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
