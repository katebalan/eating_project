<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\Consumption;
use EatingBundle\Entity\User;
use EatingBundle\Form\ConsumptionFormType;
use EatingBundle\Service\ChangingConsumptionService;
use EatingBundle\Service\CountService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Tests\Fixtures\ToString;

/**
 * Class ConsumptionController
 * @package EatingBundle\Controller
 */
class ConsumptionController extends Controller
{
    /**
     * Controller are used for create new consumption only for user,
     * that is log in system, and change current values in user entity
     *
     * @param Request $request
     * @param User $user
     * @param CountService $countService
     * @return RedirectResponse|array
     * @Route("/consumption/{id}/new", name="consumption_new")
     * @Template()
     */
    public function newAction(CountService $countService, Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ConsumptionFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $consumption = $form->getData();

            $consumption->setUser($user);
            $consumption->setCreatedAt(new \DateTime('now'));

            $user = $countService->CountCurrentValues($user, $consumption->getHowMuch(), $consumption->getProduct());

            $em->persist($consumption);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'You have eaten ' . $consumption->getProduct()->getName() . '!');

            return $this->redirectToRoute('user_show', [
                'id' => $user->getId()
            ]);
        }

        return [
            'form' =>$form->createView()
        ];
    }

    /**
     * @param User $user
     * @return array
     * @Route("/user/{id}/history", name="consumption_history")
     * @Template()
     */
    public function historyAction(User $user, ChangingConsumptionService $changingConsumptionService)
    {
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (!$this->isGranted('ROLE_ADMIN') && $this->getUser() != $user) {
            throw new AccessDeniedException('This user does not have access to this action.');
        }

        $day_consumption = array();

        for ($i = 0; $i < 5; $i++) {
            $date = new \DateTime();
            $date->modify('-'.$i.' days');
            $em = $this->getDoctrine()->getManager();
            $consumption = $em->getRepository('EatingBundle:Consumption')
                ->findByDateAndUserActive($user, $date);
            $str_date = $date->format('Y-m-d');

            if ( !empty($consumption)) {
                $day_consumption[$str_date]['breakfast'] = array();
                $day_consumption[$str_date]['dinner'] = array();
                $day_consumption[$str_date]['supper'] = array();
            }

            for ($j = 0; $j < count($consumption); $j++) {
                if ($consumption[$j]->getMealsOfTheDay() == 'Breakfast') {
                    array_push($day_consumption[$str_date]['breakfast'], $consumption[$j]);
                }
                if ($consumption[$j]->getMealsOfTheDay() == 'Dinner') {
                    array_push($day_consumption[$str_date]['dinner'], $consumption[$j]);
                }
                if ($consumption[$j]->getMealsOfTheDay() == 'Supper') {
                    array_push($day_consumption[$str_date]['supper'], $consumption[$j]);
                }
            }
        }

        return [
            'user' => $user,
            'days_consumption' => $day_consumption
        ];
    }

}
