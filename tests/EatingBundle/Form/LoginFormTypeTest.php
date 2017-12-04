<?php

use Symfony\Component\Form\Test\TypeTestCase;
use EatingBundle\Form\LoginFormType;

class LoginFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $form_data = [
            '_username' => 'ket11@ukr.net',
            '_password' => '5177849',
        ];
        $form = $this->factory->create(LoginFormType::class);

        $form->submit($form_data);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($form_data, $form->getData());
    }
}
