<?php
// ItemFilterType.php
namespace DonsBundle\Form;

use DonsBundle\Entity\Don;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Symfony\Component\OptionsResolver\ConditionBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\FormBuilder;


class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('title', Filters\TextFilterType::class);
        $builder->add('ups', Filters\NumberFilterType::class);

    }

    public function getBlockPrefix()
    {
        return 'item_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}