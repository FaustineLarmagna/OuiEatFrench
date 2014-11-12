<?php

namespace OuiEatFrench\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class EditoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                "label"     => "Titre",
                "required"   => true
            ))
            ->add('text', 'textarea', array(
                "label"     => "Texte",
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
            'data_class' => 'OuiEatFrench\AdminBundle\Entity\Edito'
        ));
    }

    public function getName()
    {
        return 'ouieatfrench_adminbundle_editotype';
    }
}
