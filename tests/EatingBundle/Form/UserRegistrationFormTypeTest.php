<?php

use Symfony\Component\Form\Test\TypeTestCase;
use EatingBundle\Form\UserRegistrationFormType;
use EatingBundle\Entity\User;

class UserRegistrationFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $form_data = [
            'firstName' => 'Harry',
            'secondName' => 'Potter',
            'age' => '16',
            'gender' => true,
            'phone' => '103',
            'email' => 'harrypotter@gmail.com',
            'weight' => '60',
            'height' => '170',
            'energy_exchange' => 1.1,
        ];

        $objectToCompare = new User();
        $form = $this->factory->create(UserRegistrationFormType::class, $objectToCompare);

        $user = new User();

        $user->setFirstName($form_data['firstName']);
        $user->setSecondName($form_data['secondName']);
        $user->setAge($form_data['age']);
        $user->setGender($form_data['gender']);
        $user->setPhone($form_data['phone']);
        $user->setEmail($form_data['email']);
        $user->setWeight($form_data['weight']);
        $user->setHeight($form_data['height']);

        $form->submit($form_data);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($user, $form->getData());
    }
}
