<?php

use Symfony\Component\Form\Test\TypeTestCase;
use EatingBundle\Form\ConsumptionFormType;
use EatingBundle\Entity\Consumption;

class ConsumptionFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $product = new \EatingBundle\Entity\Products();
        $formData = array(
            'product' => $product,
            'how_much' => 200,
            'meals_of_the_day' => 'Dinner'
        );

        $objectToCompare = new Consumption();
        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(ConsumptionFormType::class, $objectToCompare);

        $object = new Consumption();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
