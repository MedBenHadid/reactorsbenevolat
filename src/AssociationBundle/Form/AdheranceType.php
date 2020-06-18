<?php

namespace AssociationBundle\Form;

use AppBundle\Entity\User;
use AssociationBundle\Entity\Adherance;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdheranceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fonction')->add('description')->add('role', ChoiceType::class, [
            'choices'  => [
                'Livreur' => Adherance::DELIVER,
                'Chef projets' => Adherance::WRITE,
                'Membre honoraire' => Adherance::READ,
            ],
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AssociationBundle\Entity\Adherance'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'associationbundle_adherance';
    }


}
