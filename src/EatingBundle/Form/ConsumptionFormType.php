<?php

namespace EatingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsumptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('how_much')
            ->add('product_name')
            ->add('meals_of_the_day', ChoiceType::class, [
                'choices' => [
                    'Breakfast' => 'Breakfast',
                    'Dinner' => 'Dinner',
                    'Supper' => 'Supper'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'eating_bundle_consumption_form_type';
    }
}
