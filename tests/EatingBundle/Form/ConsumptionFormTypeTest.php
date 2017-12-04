<?php

use Symfony\Component\Form\Test\TypeTestCase;
use EatingBundle\Form\ConsumptionFormType;

class ConsumptionFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $form_data = [
            'product_name' => 'Soup',
            'how_much' => 200,
            'meals_of_the_day' => 'Dinner'
        ];

        $form = $this->factory->create(ConsumptionFormType::class);

        $form->submit($form_data);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($form_data, $form->getData());
    }
}
