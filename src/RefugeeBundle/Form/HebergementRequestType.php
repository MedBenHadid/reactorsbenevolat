<?php

namespace RefugeeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HebergementRequestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isAnonymous', CheckboxType::class)
            ->add('name')
            ->add('telephone')
            ->add('description')
            ->add('region')
            ->add('nativeCountry')
            ->add('arrivalDate', DateType::class)
            ->add('passportNumber')
            ->add('civilStatus', ChoiceType::class,
                [
                    'label' => 'Etat Civil: ',
                    'choices' => [
                        'Marié(e)' => 0,
                        'Celibatair(e)' => 1
                    ]
                ])
            ->add('childrenNumber');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RefugeeBundle\Entity\HebergementRequest'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'refugeebundle_hebergementrequest';
    }


}
