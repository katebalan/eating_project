<?php

namespace EatingBundle\Security;


use EatingBundle\Form\LoginFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->$formFactory = $formFactory;
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == "/login" && $request->isMethod('POST');

        if(!$isLoginSubmit) {
            // skip authentication
            return;
        }

        $form = $this->formFactory->create(LoginFormType::class);
        $form->handleRequest($request);

        $data = $form->getData();

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // TODO: Implement getUser() method.
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // TODO: Implement checkCredentials() method.
    }

}
