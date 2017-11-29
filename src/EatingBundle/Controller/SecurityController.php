<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\User;
use EatingBundle\Form\LoginFormType;
use EatingBundle\Form\UserRegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction()
    {
//        $this->denyAccessUnlessGranted('ROLE_ANONYMOUS');

        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginFormType::class, [
            '_username' => $lastUsername,
        ]);

        return $this->render(
            '@Eating/security/login.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $error,
            )
        );

    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
//        $this->denyAccessUnlessGranted('ROLE_ANONYMOUS');

        $form = $this->createForm(UserRegistrationFormType::class);

        $form->handleRequest($request);

        if($form->isValid()) {
            /** @var User $user */
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
            $user->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getFirstName().' '.$user->getSecondName());

//            return $this->redirectToRoute('user_show', ['userId' => $user->getId()]);
            return $this->get('security.authentication.guard_handler')->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->get('app.security.login_form_authenticator'),
                'main'
            );
        }

        return $this->render('@Eating/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
