<?php

namespace OuiEatFrench\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                "label"     => "Name",
                "required"   => true
            ))
            ->add('description', 'textarea', array(
                "label"     => "Description",
                "required"   => true
            ))
            ->add('parent_category', 'text', array(
                "label"     => "Category Parent",
                "required"   => true
            ))
            ->add('image', 'file', array(
                "label"     => "Image",
                "required"   => true
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OuiEatFrench\AdminBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'ouieatfrench_adminbundle_producttype';
    }
}

?>
 