<?php

use Symfony\Component\Form\Test\TypeTestCase;
use EatingBundle\Form\ProductsFormType;

class ProductFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $form_data = [
            'name' => 'Soup',
            'kkal_per_100gr' => 100,
            'proteins_per_100gr' => 10,
            'fats_per_100gr' => 10,
            'carbohydrates_per_100gr' => 10,
            'rating' => '2'
        ];

        $form = $this->factory->create(ProductsFormType::class);

        $product = new \EatingBundle\Entity\Products();
        
        $product->setName($form_data['name']);
        $product->setKkalPer100gr($form_data['kkal_per_100gr']);
        $product->setProteinsPer100gr($form_data['proteins_per_100gr']);
        $product->setFatsPer100gr($form_data['fats_per_100gr']);
        $product->setCarbohydratesPer100gr($form_data['carbohydrates_per_100gr']);
        $product->setRating($form_data['rating']);

        $form->submit($form_data);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($product, $form->getData());
    }
}
