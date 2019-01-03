<?php

namespace EatingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('kkal_per_5minutes')
            ->add('proteins_per_5minutes')
            ->add('fats_per_5minutes')
            ->add('carbohydrates_per_5minutes')
            ->add('rating', ChoiceType::class, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label'],
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Download image (png, jpeg, jpg)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'EatingBundle\Entity\Activity',
            'attr' => ['class' => 'ea-form__inside' ]
        ]);
    }

    public function getBlockPrefix()
    {
        return 'eating_bundle_activity_form_type';
    }
}
