<?php

namespace RefugeeBundle\Form;

use RefugeeBundle\Entity\Hebergement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class,
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
                ])
            ->add('hebergement', EntityType::class,
                ['class' => Hebergement::class]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RefugeeBundle\Entity\Image'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'refugeebundle_image';
    }


}
