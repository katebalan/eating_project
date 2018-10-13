<?php

namespace EatingBundle\Form;

use EatingBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ])
            ->add('firstName', null)
            ->add('secondName', null)
            ->add('age', null)
            ->add('gender', ChoiceType::class, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label'],
                'choices' => [
                    'Male' => true,
                    'Female' => false,
                ]
            ])
            ->add('phone', null)
            ->add('weight', null)
            ->add('height', null)
            ->add('energyExchange', ChoiceType::class, [
                'attr' => ['class' => 'ea-form__field'],
                'label_attr' => ['class' => 'ea-form__label'],
                'choices' => [
                    'Low activity (you are passive)' => 1.3,
                    'Moderate activity (work is sitting, but the office has to run, and in addition, two or three times a week you find time for sports).' => 1.5,
                    'High activity (your work is a constant movement)' => 1.7
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' =>['Default', 'Registration']
        ]);
    }

    public function getBlockPrefix()
    {
        return 'eating_bundle_user_registration_form_type';
    }
}
