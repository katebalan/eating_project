<?php

namespace EatingBundle\Controller;

use EatingBundle\Form\LoginFormType;
use EatingBundle\Form\UserRegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction()
    {
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
    public function registerAction()
    {
        $form = $this->createForm(UserRegistrationFormType::class);

        return $this->render('@Eating/security/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
