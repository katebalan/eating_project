<?php

namespace EatingBundle\Controller;

use EatingBundle\Form\UserFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
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
     * @Route("/admin/user/new", name="user_new")
     */
    public function userNewAction(Request $request)
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(UserFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $weight = $user->getWeight();
            $energy_exchange = $user->getEnergyExchange();
            $daily_kkal = 0;

            if($user->getAge() <= 30 && $user->getGender() == false) {
                $daily_kkal = (0.0621 * $weight + 2.0357) * 240 * $energy_exchange;
            }
            elseif($user->getAge() > 30 && $user->getAge() <= 60 && $user->getGender() == false) {
                $daily_kkal = (0.0342 * $weight + 3.5377) * 240 * $energy_exchange;
            }
            elseif($user->getAge() > 60 && $user->getGender() == false) {
                $daily_kkal = (0.0377 * $weight + 2.7545) * 240 * $energy_exchange;
            }
            elseif($user->getAge() <= 30 && $user->getGender() == true) {
                $daily_kkal = (0.0630 * $weight + 2.8957) * 240 * $energy_exchange;
            }
            elseif($user->getAge() > 30 && $user->getGender() == true) {
                $daily_kkal = (0.0491 * $weight + 2.4587) * 240 * $energy_exchange;
            }
            else {
                $user->setDailyKkal(0);
            }

            $user->setDailyKkal(round($daily_kkal));
            $daily_parts = round($daily_kkal / 6, 2, PHP_ROUND_HALF_UP);

            $daily_fats = round($daily_parts / 9, 2, PHP_ROUND_HALF_UP);
            $daily_proteins = round($daily_parts / 4, 2, PHP_ROUND_HALF_UP);
            $daily_carbohydrates = $daily_parts;

            $user->setDailyFats($daily_fats);
            $user->setDailyProteins($daily_proteins);
            $user->setDailyCarbohydrates($daily_carbohydrates);
            $user->setPassword('1');

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
     * @Route("/user/{userId}", name="user_show")
     */
    public function userShowAction($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('EatingBundle:User')->findOneBy(['id' => $userId]);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $consumption = $em->getRepository('EatingBundle:Consumption')->findBy(['user' => $user]);


        $products = $em->getRepository('EatingBundle:Products')->findBy(['id' => $consumption[0]->getProduct()]);
        dump($products);
        exit;
        return $this->render('@Eating/User/user_show.html.twig', [
            'user' => $user,
            'consumption' => $consumption
        ]);
    }
}
