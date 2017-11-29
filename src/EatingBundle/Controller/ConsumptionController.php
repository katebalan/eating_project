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
//            dump($user->getCurrentKkal());
//            exit;

            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('EatingBundle:Products')->findOneBy(['name' => $form_info['product_name']]);

            if( empty($product) ) {
                $this->addFlash('error', 'Product doesn\'t exist');

            }
            else {
                $consumption = new Consumption();

                $consumption->setHowMuch($form_info['how_much']);
                $consumption->setMealsOfTheDay($form_info['meals_of_the_day']);
                $consumption->setUser($user);
                $consumption->setProduct($product);
                $consumption->setCreatedAt(new \DateTime('now'));
                $current_kkal = $consumption->getHowMuch() * $product->getKkalPer100gr() / 100;
                $user->setCurrentKkal($current_kkal);
                $current_proteins = $consumption->getHowMuch() * $product->getProteinsPer100gr() / 100;
                $user->setCurrentProteins($current_proteins);
//                To DO FATS, Carbohydrates

                $em->persist($consumption);
                $em->flush();

                $this->addFlash('success', 'You have eaten new product!');

                return $this->redirectToRoute('user_show', [
                    'userId' => $user->getId()
                ]);
            }
        }

        return $this->render('@Eating/Consumption/consumption_new.html.twig', [
            'form' =>$form->createView()
        ]);
    }
}
