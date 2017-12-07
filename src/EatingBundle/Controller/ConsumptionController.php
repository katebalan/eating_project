<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\Consumption;
use EatingBundle\Entity\User;
use EatingBundle\Form\ConsumptionFormType;
use EatingBundle\Service\CountService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ConsumptionController extends Controller
{
    /**
     * Controller are used for create new consumption only for user,
     * that is log in system, and change current values in user entity
     *
     * @param Request $request
     * @param User $user
     * @param CountService $countService
     * @return RedirectResponse|Response
     * @Route("/consumption/{id}/new", name="consumption_new")
     */
    public function consumptionNewAction(CountService $countService, Request $request, User $user)
    {
        $form = $this->createForm(ConsumptionFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
//            $user = $this->getUser();
            $form_info = $form->getData();

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

                $user = $countService->CountCurrentValues($user, $consumption->getHowMuch(), $product);

                $em->persist($consumption);
                $em->persist($user);
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

    /**
     * @param User $user
     * @return Response
     * @Route("/user/{id}/history", name="consumption_history")
     */
    public function consumptionHistoryAction(User $user)
    {
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (!$this->isGranted('ROLE_ADMIN') && $this->getUser() != $user) {
            throw new AccessDeniedException('This user does not have access to this action.');
        }

        $day_consumption = array();

        for ($i = 0; $i < 5; $i++) {
            $date = date('y-m-d', strtotime('-'.$i.' days', time()));
            $em = $this->getDoctrine()->getManager();
            $consumption = $em->getRepository('EatingBundle:Consumption')
                ->findByDateAndUserActive($user, $date);

            if ( !empty($consumption)) {
                $day_consumption[$date]['breakfast'] = array();
                $day_consumption[$date]['dinner'] = array();
                $day_consumption[$date]['supper'] = array();
            }

            for ($j = 0; $j < count($consumption); $j++) {
                if ($consumption[$j]->getMealsOfTheDay() == 'Breakfast') {
                    array_push($day_consumption[$date]['breakfast'], $consumption[$j]);
                }
                if ($consumption[$j]->getMealsOfTheDay() == 'Dinner') {
                    array_push($day_consumption[$date]['dinner'], $consumption[$j]);
                }
                if ($consumption[$j]->getMealsOfTheDay() == 'Supper') {
                    array_push($day_consumption[$date]['supper'], $consumption[$j]);
                }
            }
        }

        return $this->render('@Eating/Consumption/consumption_history.html.twig', [
            'user' => $user,
            'days_consumption' => $day_consumption
        ]);
    }

}
