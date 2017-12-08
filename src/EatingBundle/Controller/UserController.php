<?php

namespace EatingBundle\Controller;

use EatingBundle\Form\UserFormType;
use EatingBundle\Service\CountService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    /**
     * Controller are used to show all users in system
     *
     * @return mixed
     * @Route("/admin/user", name="user_list")
     */
    public function userListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('EatingBundle:User')->findAll();

        return $this->render('@Eating/User/user_list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Controller are used to create new user
     *
     * @param Request $request
     * @param CountService $countService
     * @return mixed
     * @Route("/admin/user/new", name="user_new")
     */
    public function userNewAction(CountService $countService, Request $request)
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(UserFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user = $countService->CountDailyValues($user);

            $user->setPlainPassword('fuckyou');
            $user->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'New user is created!');
            return $this->redirectToRoute('user_list');
        }
        return $this->render('@Eating/User/user_new.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * Controller are used to show user page
     *
     * @param $userId
     * @return mixed
     * @Route("/user/{userId}", name="user_show")
     */
    public function userShowAction($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('EatingBundle:User')->findOneBy(['id' => $userId]);

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (!$this->isGranted('ROLE_ADMIN') && $this->getUser() != $user) {
            throw new AccessDeniedException('This user does not have access to this action.');
        }

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $date = date('y-m-d', time());

        $consumption = $em->getRepository('EatingBundle:Consumption')->findByDateAndUserActive($user, $date);

        if( empty($consumption))
        {
            $user->setCurrentKkal(0);
            $user->setCurrentProteins(0);
            $user->setCurrentFats(0);
            $user->setCurrentCarbohydrates(0);
        }

        $em->persist($user);
        $em->flush();

        $day_consumption = array();

        if ( !empty($consumption)) {
            $day_consumption['breakfast'] = array();
            $day_consumption['dinner'] = array();
            $day_consumption['supper'] = array();
        }

        for ($j = 0; $j < count($consumption); $j++) {
            if ($consumption[$j]->getMealsOfTheDay() == 'Breakfast') {
                array_push($day_consumption['breakfast'], $consumption[$j]);
            }
            if ($consumption[$j]->getMealsOfTheDay() == 'Dinner') {
                array_push($day_consumption['dinner'], $consumption[$j]);
            }
            if ($consumption[$j]->getMealsOfTheDay() == 'Supper') {
                array_push($day_consumption['supper'], $consumption[$j]);
            }
        }

        return $this->render('@Eating/User/user_show.html.twig', [
            'day_consumption' => $day_consumption,
            'user' => $user
        ]);
    }
}
