<?php

namespace EatingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null)
            ->add('secondName', null)
            ->add('email', EmailType::class)
            ->add('age', null)
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => true,
                    'Female' => false,
                ]
            ])
            ->add('phone', null)
            ->add('weight', null)
            ->add('height', null)
            ->add('energyExchange', ChoiceType::class, [
                'choices' => [
                    'Low activity (you are passive)' => 1.1,
                    'Moderate activity (work is sitting, but the office has to run, and in addition, two or three times a week you find time for sports).' => 1.3,
                    'High activity (your work is a constant movement)' => 1.5
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'EatingBundle\Entity\User',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'eating_bundle_user_form_type';
    }
}
