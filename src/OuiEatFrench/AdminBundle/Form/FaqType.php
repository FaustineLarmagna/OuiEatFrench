<?php

namespace OuiEatFrench\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class FaqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                "label"     => "Titre",
                "required"   => true
            ))
            ->add('question', 'textarea', array(
                "label"     => "Question",
                "required"   => true
            ))
            ->add('answer', 'textarea', array(
                "label"     => "Réponce",
                "required"   => true
            ))
            ->add('disable', 'choice', array(
                'choices' => array(
                    '0' => 'Non visible',
                    '1' => 'Visible',
                ),
                "label"     => "Réponce",
                "required"   => true
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OuiEatFrench\AdminBundle\Entity\Faq'
        ));
    }

    public function getName()
    {
        return 'ouieatfrench_adminbundle_faqtype';
    }
}
