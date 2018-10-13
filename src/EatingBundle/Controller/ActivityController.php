<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\Activity;
use EatingBundle\Form\ActivityFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActivityController
 * @package EatingBundle\Controller
 */
class ActivityController extends Controller
{
    /**
     * Controller are used to show list of all activity
     *
     * @return mixed
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
     * Controller are used to create new activity
     *
     * @param Request $request
     * @return mixed
     * @Route("/activity/new", name="activity_new")
     */
    public function activityNewAction(Request $request)
    {
        $form = $this->createForm(ActivityFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();
            $activity->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();

            $this->addFlash('success', 'New activity is creted!');
            return $this->redirectToRoute('activity_list');
        }

        return $this->render('EatingBundle:Activity:new.html.twig', [
            'activityForm' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Activity $activity
     * @return Response
     * @Route("/activity/{id}/edit", name="activity_edit")
     */
    public function activityEditAction(Request $request, Activity $activity)
    {
        $form = $this->createForm(ActivityFormType::class, $activity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();

            $this->addFlash('success', 'Activity is updated!');
            return $this->redirectToRoute('activity_list');
        }
        return $this->render('@Eating/Activity/edit.html.twig', [
            'activityForm' => $form->createView()
        ]);
    }
}
