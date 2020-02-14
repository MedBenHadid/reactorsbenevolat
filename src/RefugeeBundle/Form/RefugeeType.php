<?php

namespace RefugeeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RefugeeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nativeCountry', TextType::class, ['label' => 'Pays d\'orgine: '])
            ->add('caseDescription', TextareaType::class, ['label' => 'Description du cas: '])
            ->add('arrivalDate', DateType::class, ['label' => 'Date d\'arrivée: '])
            ->add('passportNumber', TextType::class, ['label' => 'Numéro du passport: '])
            ->add('civilStatus', ChoiceType::class,
                [
                    'label' => 'Etat Civil: ',
                    'choices' => [
                        'Marié(e)' => 0,
                        'Celibatair(e)' => 1
                    ]
                ])
            ->add('childrenNumber', TextType::class, ['label' => 'Nombre d\'enfants'])
            ->add('user');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RefugeeBundle\Entity\Refugee'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'refugeebundle_refugee';
    }


}
