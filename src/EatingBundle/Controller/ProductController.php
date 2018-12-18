<?php
declare(strict_types=1);

namespace EatingBundle\Controller;

use EatingBundle\Entity\Products;
use EatingBundle\Form\ProductsFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class ProductsController
 * @package EatingBundle\Controller
 *
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Controller are used for show list of all products
     *
     * @return mixed
     * @Route("/", name="product_list")
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('EatingBundle:Products')->findAllOrderedByDescActive();

        return [
            'products' => $products
        ];
    }

    /**
     * Controller are used to create new product
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/new", name="product_new")
     * @Template()
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(ProductsFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setCreatedAt(new \DateTime('now'));

            $file = $product->getImage();

            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('file_directory') . 'products/',
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents
                $product->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'New product is created!');

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }
        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @param Products $product
     * @return mixed
     * @Route("/{id}", name="product_show")
     * @Template()
     */
    public function showAction(?Products $product)
    {
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        return [
            'product' => $product
        ];
    }

    /**
     * @param Request $request
     * @param Products|null $product
     * @return mixed
     * @Route("/{id}/edit", name="product_edit")
     * @Template()
     */
    public function editAction(Request $request, ?Products $product)
    {
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        $fileName = $product->getImage();
        if ($fileName) {
            $product->setImage(
                new File($this->getParameter('file_directory') . 'products/' . $fileName)
            );
        }

        $form = $this->createForm(ProductsFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $file = $product->getImage();

            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('file_directory') . 'products/',
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents
            }
            $product->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Product is updated!');

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @param Products|null $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/delete", name="product_delete")
     */
    public function deleteAction(?Products $product)
    {
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();

            $this->addFlash('success', 'Product '.$product->getName().' was deleted!');
        }

        return $this->redirectToRoute('product_list');
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
