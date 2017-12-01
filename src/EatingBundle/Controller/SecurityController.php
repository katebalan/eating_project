<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\User;
use EatingBundle\Form\LoginFormType;
use EatingBundle\Form\UserRegistrationFormType;
use EatingBundle\Service\CountService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * Controller are used to login users
     *
     * @return Response
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
     * Controller are used to logout users
     *
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }

    /**
     * Controller are used to register new users
     *
     * @param Request $request
     * @param CountService $countService
     * @return mixed
     * @Route("/register", name="user_register")
     */
    public function registerAction(CountService $countService, Request $request)
    {
    //        $this->denyAccessUnlessGranted('ROLE_ANONYMOUS');

        $form = $this->createForm(UserRegistrationFormType::class);

        $form->handleRequest($request);

        if($form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $user = $countService->CountDailyValues($user);
            $user->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getFirstName().' '.$user->getSecondName());

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
