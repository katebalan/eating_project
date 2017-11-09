<?php

namespace EatingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label']
            ])
            ->add('kkal_per_5minutes', null, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label']
            ])
            ->add('proteins_per_5minutes', null, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label']
            ])
            ->add('fats_per_5minutes', null, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label']
            ])
            ->add('carbohydrates_per_5minutes', null, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label']
            ])
            ->add('rating', null, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'EatingBundle\Entity\Activity',
            'attr' => ['class' => 'ea-form__inside' ],
        ]);
    }

    public function getBlockPrefix()
    {
        return 'eating_bundle_activity_form_type';
    }
}