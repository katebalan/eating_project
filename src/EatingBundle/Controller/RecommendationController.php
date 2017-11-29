<?php
namespace EatingBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
class RecommendationController extends Controller
{
    /**
     * @Route("/recommendation", name="recommendation_list")
     */
    public function productsListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('EatingBundle:Products')->findAllOrderedByDescActive();
        $pr = array();

        $user = $this->getUser();

        $proteins = $user->getDailyProteins() - $user->getCurrentProteins();
        $fats = $user->getDailyFats() - $user->getCurrentFats();
        $carbohydrates = $user->getDailyCarbohydrates() - $user->getCurrentCarbohydrates();

        $sum = $proteins + $fats + $carbohydrates;
        $proteins = 100 * $proteins / $sum;
        $fats = 100 * $fats / $sum;
        $carbohydrates = 100 * $carbohydrates / $sum;

        foreach ($products as $i => $value) {
            $Dproteins = $products[$i]->getProteinsPer100gr() - $proteins;
            $Dfats = $products[$i]->getFatsPer100gr() - $fats;
            $Dcarbohydrates = $products[$i]->getCarbohydratesPer100gr() - $carbohydrates;
            if( $Dproteins * $Dproteins + $Dfats * $Dfats + $Dcarbohydrates * $Dcarbohydrates < 3000)
                $pr[] = $products[$i];
        }

        usort($pr, function($a, $b) {
            /* if ($a == $b)
            {
                return 0;
            }
            else */
            if ($a->getRating() > $b->getRating()) {
                return -1;
            }
            else {
                return 1;
            }
        });

        return $this->render('EatingBundle:Recommendation:list.html.twig', [
            'products' => $pr
        ]);
    }


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
