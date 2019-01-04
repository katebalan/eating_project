<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\User;
use EatingBundle\Form\UserFormType;
use EatingBundle\Form\UserPasswordType;
use EatingBundle\Service\CountService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Count;

/**
 * Class UserController
 * @package EatingBundle\Controller
 */
class UserController extends Controller
{
    /**
     * Controller are used to show all users in system
     *
     * @return mixed
     * @Route("/admin/user", name="user_list")
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('EatingBundle:User')->findAll();

        return [
            'users' => $users
        ];
    }

    /**
     * Controller are used to create new user
     *
     * @param Request $request
     * @param CountService $countService
     * @return mixed
     * @Route("/admin/user/new", name="user_new")
     * @Template()
     * @throws \Exception
     */
    public function newAction(CountService $countService, Request $request)
    {
        $form = $this->createForm(UserFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user = $countService->countDailyValues($user);

            $user->setPlainPassword('fuckyou');
            $user->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'New user is created!');
            return $this->redirectToRoute('user_list');
        }

        return [
            'userForm' => $form->createView()
        ];
    }

    /**
     * Controller are used to show user page
     *
     * @param User $user
     * @return mixed
     * @Route("/user/{id}", name="user_show")
     * @Template()
     * @throws \Exception
     */
    public function showAction(User $user, CountService $countService)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$this->isGranted('ROLE_ADMIN') && $this->getUser() != $user) {
            throw new AccessDeniedException('This user does not have access to this action.');
        }

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $date = new \DateTime();

        $consumption = $em->getRepository('EatingBundle:Consumption')->findByDateAndUserActive($user, $date);

        if ( empty($consumption)) {
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

        return [
            'day_consumption' => $day_consumption,
            'user' => $user
        ];
    }


    /**
     * @param Request $request
     * @param User|null $user
     * @return mixed
     * @Route("/user/{id}/edit", name="user_edit")
     * @Template()
     */
    public function editAction(Request $request, ?User $user)
    {
        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        if (!$this->isGranted('ROLE_ADMIN') && $this->getUser() != $user) {
            throw new AccessDeniedException('This user does not have access to this action.');
        }

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            var_dump($user);
            exit;
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User is updated!');

            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        return [
            'form' => $form->createView()
        ];
    }


    /**
     * @param Request $request
     * @param User|null $user
     * @Route("/user/{id}/edit_password", name="user_edit_password")
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template()
     */
    public function editPasswordAction(Request $request, ?User $user)
    {
        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        if (!$this->isGranted('ROLE_ADMIN') && $this->getUser() != $user) {
            throw new AccessDeniedException('This user does not have access to this action.');
        }

        $form = $this->createForm(UserPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User\'s password is updated!');

            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        return [
            'form' => $form->createView()
        ];
    }
}
