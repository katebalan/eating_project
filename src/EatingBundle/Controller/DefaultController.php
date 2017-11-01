<?php

namespace EatingBundle\Controller;

use EatingBundle\Form\ProductsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="products_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('EatingBundle:Products')->findAllOrderedByDescActive();

        return $this->render('EatingBundle::list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/new", name="products_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(ProductsFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setCreatedAt(new \DateTime('-1 month'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'New product is created!');

            return $this->redirectToRoute('products_list');
        }
        return $this->render('EatingBundle::new.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
}
