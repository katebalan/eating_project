<?php

namespace EatingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsumptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_name', null, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label']
            ])
            ->add('how_much', IntegerType::class, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label']
            ])
            ->add('meals_of_the_day', ChoiceType::class, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label'],
                'choices' => [
                    'Breakfast' => 'Breakfast',
                    'Dinner' => 'Dinner',
                    'Supper' => 'Supper'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => ['class' => 'ea-form__inside' ]
        ]);
    }

    public function getBlockPrefix()
    {
        return 'eating_bundle_consumption_form_type';
    }
}
