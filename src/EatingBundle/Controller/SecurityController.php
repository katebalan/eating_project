<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\User;
use EatingBundle\Form\LoginFormType;
use EatingBundle\Form\UserRegistrationFormType;
use EatingBundle\Security\LoginFormAuthenticator;
use EatingBundle\Service\CountService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package EatingBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * Controller are used to login users
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @Route("/login", name="security_login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
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
     * @throws \Exception
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
     * @param GuardAuthenticatorHandler $authenticatorHandler
     * @param LoginFormAuthenticator $authenticator
     * @return mixed
     * @Route("/register", name="user_register")
     * @throws \Exception
     */
    public function registerAction(
        CountService $countService,
        Request $request,
        GuardAuthenticatorHandler $authenticatorHandler,
        LoginFormAuthenticator $authenticator
    ) {
        $form = $this->createForm(UserRegistrationFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $user = $countService->countDailyValues($user);
            $user->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getFirstName().' '.$user->getSecondName());

            return $authenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }

        return $this->render('@Eating/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
