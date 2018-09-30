<?php

namespace PatientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class PatientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('cin')
        ->add('image',FileType::class,array('label'=>'image png ou jpeg', 'data_class'=>null))
        ->add('prenom')
        ->add('nom')
        ->add('datenaissance', DateType::class,array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd'
        ))
        ->add('lieunaissance')
        ->add('adresse')
        ->add('tele')
        ->add('email')
        ->add('etatcivil',ChoiceType::class, array(
            'choices' => array(
                'Célibataire(V)' => "Célibataire(V)",
                'Célibataire(NV)' => "Célibataire(NV)",
                'Mariée' => "Mariée",
                'Divercée' => "Divercée",
             ),
      ))
        ->add('profession')
        ->add('referent')
        ->add('type',ChoiceType::class, array(
            'choices' => array(
                'Gyénéchologique' => "Gyénéchologique",
                'Obstetrique' => "Obstetrique",

            ),
      ))

        ->add('code')
        ->add('metuelles',EntityType::class, array(
            'class' => 'PatientBundle\Entity\metuele',
            'choice_label' => ' societe',
            'expanded' => false,
            'multiple' => true)
        );
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PatientBundle\Entity\Patient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'patientbundle_patient';
    }


}
