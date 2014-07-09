<?php

namespace OuiEatFrench\MailingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class LandingCustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                "label"     => "form.email",
                "required"   => true
            ))
            ->add('lastname', 'text', array(
                "label"     => "form.lastname",
                "required"   => true
            ))
            ->add('firstname', 'text', array(
                "label"     => "form.firstname",
                "required"   => true
            ))
            ->add('postcode', 'text', array(
                "label"     => "form.postcode",
                "required"   => true
            ))
        ;
    }
    public function getName()
    {
        return 'ouieatfrench_mailingbundle_landingcustomertype';
    }
}

?>
