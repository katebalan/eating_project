<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\Products;
use EatingBundle\Form\ProductsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller
{
    /**
     * Controller are used for show list of all products
     *
     * @return mixed
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
     * Controller are used to create new product
     *
     * @param Request $request
     * @return mixed
     * @Route("/products/new", name="products_new")
     */
    public function productsNewAction(Request $request)
    {
        $form = $this->createForm(ProductsFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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

    /**
     * @param Request $request
     * @param Products $product
     * @return mixed
     * @Route("/products/{id}/edit", name="product_edit")
     */
    public function productsEditAction(Request $request, Products $product)
    {
        $form = $this->createForm(ProductsFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Product is updated!');

            return $this->redirectToRoute('products_list');
        }

        return $this->render('@Eating/Products/edit.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
}
