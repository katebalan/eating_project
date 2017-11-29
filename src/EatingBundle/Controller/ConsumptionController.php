<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\Consumption;
use EatingBundle\Form\ConsumptionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConsumptionController extends Controller
{
    /**
     * @Route("/consumption/new", name="consumption_new")
     */
    public function consumptionNewAction(Request $request)
    {
        $form = $this->createForm(ConsumptionFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $form_info = $form->getData();

            $consumption = new Consumption();
            $consumption->setHowMuch($form_info['how_much']);
            $consumption->setMealsOfTheDay($form_info['meals_of_the_day']);
            $consumption->setCreatedAt(new \DateTime('now'));
            $consumption->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('EatingBundle:Products')->findOneBy(['name' => $form_info['product_name']]);
            
            $consumption->setProduct($product);

            dump($form_info);
            dump($form_info['how_much']);
            dump($consumption);
            exit;
        }

        return $this->render('@Eating/Consumption/consumption_new.html.twig', [
            'form' =>$form->createView()
        ]);
    }
}
