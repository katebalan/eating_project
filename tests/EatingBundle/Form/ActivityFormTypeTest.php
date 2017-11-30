<?php

use Symfony\Component\Form\Test\TypeTestCase;
use EatingBundle\Form\ActivityFormType;
use EatingBundle\Entity\Activity;

class ActivityFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $form_data = [
            'name' => 'Soup',
            'kkal_per_5minutes' => 100,
            'proteins_per_5minutes' => 10,
            'fats_per_5minutes' => 10,
            'carbohydrates_per_5minutes' => 10,
            'rating' => '2'
        ];

        $form = $this->factory->create(ActivityFormType::class);

        $activity = new Activity();

        $activity->setName($form_data['name']);
        $activity->setKkalPer5minutes($form_data['kkal_per_5minutes']);
        $activity->setProteinsPer5minutes($form_data['proteins_per_5minutes']);
        $activity->setFatsPer5minutes($form_data['fats_per_5minutes']);
        $activity->setCarbohydratesPer5minutes($form_data['carbohydrates_per_5minutes']);
        $activity->setRating($form_data['rating']);

        $form->submit($form_data);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($activity, $form->getData());
    }
}
