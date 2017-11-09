<?php

namespace EatingBundle\Controller;

use EatingBundle\Form\ProductsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller
{
    /**
     * @Route("/products", name="products_list")
     */
    public function productsListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('EatingBundle:Products')->findAllOrderedByDescActive();

        return $this->render('EatingBundle:Products:list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/products/new", name="products_new")
     */
    public function productsNewAction(Request $request)
    {
        $form = $this->createForm(ProductsFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'New product is created!');

            return $this->redirectToRoute('products_list');
        }
        return $this->render('EatingBundle:Products:new.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
}
