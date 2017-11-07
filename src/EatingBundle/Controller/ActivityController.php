<?php

namespace EatingBundle\Controller;

use EatingBundle\Form\ActivityFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActivityController extends Controller
{
    /**
     * @Route("/activity", name="activity_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $activity = $em->getRepository('EatingBundle:Activity')->findAll();

        return $this->render('EatingBundle:Activity:list.html.twig', [
            'activity' => $activity
        ]);
    }

    /**
     * @Route("/activity/new", name="activity_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(ActivityFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();

            $this->addFlash('success', 'New activity is creted!');
           return $this->redirectToRoute('activity_list');
        }

        return $this->render('EatingBundle:Activity:new.html.twig', [
            'activityForm' =>$form->createView()
        ]);
    }
}
