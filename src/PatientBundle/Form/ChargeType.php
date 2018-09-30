<?php

namespace PatientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChargeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',ChoiceType::class, array(
            'choices' => array(
                'Syndie' => "Syndie",
                'Gardien' => "Gardien",
                'CROM' => "CROM",
                'Imprimerie et publicité' => "Imprimerie et publicité",
             ),
        ))
        ->add('prix')->
        add('date', DateType::class,array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd'
        ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PatientBundle\Entity\Charge'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'patientbundle_charge';
    }


}
