<?php

namespace EatingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('EatingBundle:Products')->findAllOrderedByDescActive();

        return $this->render('EatingBundle::index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/add")
     */
    public function addAction()
    {
        # TO DO
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('EatingBundle:Products')->findAllOrderedByDescActive();

        return $this->render('EatingBundle::index.html.twig', [
            'products' => $products
        ]);
    }
}
