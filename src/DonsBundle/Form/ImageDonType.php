<?php

namespace DonsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageDonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image', FileType::class,
            [
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '8m',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/svg+xml'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image file',
                    ])
                ]
            ])->add('don')->add('demande');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DonsBundle\Entity\ImageDon'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'donsbundle_imagedon';
    }


}
