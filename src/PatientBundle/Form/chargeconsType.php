<?php

namespace PatientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class chargeconsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type',ChoiceType::class, array(
            'choices' => array(
                'Hygiene' => "Hygiene",
                'Burautique' => "Burautique",
                'Materiels Medicals' => "Materiels Medicals",
                'Ravitaillement' => "Ravitaillement",
             ),
        ))
        ->add('materiele')
        ->add('date', DateType::class,array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd'
        ))
        ->add('quantite')
        ->add('prix');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PatientBundle\Entity\chargecons'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'patientbundle_chargecons';
    }


}
