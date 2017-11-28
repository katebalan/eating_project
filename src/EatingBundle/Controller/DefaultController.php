<?php

namespace EatingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $userId = null;
        if( $user ) {
            $userId = $user->getId();
        }
        // replace this example code with whatever you need
        return $this->render('@Eating/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'userId' => $userId
        ]);
    }
}
