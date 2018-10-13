<?php

namespace EatingBundle\Controller;

use EatingBundle\Entity\Activity;
use EatingBundle\Form\ActivityFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActivityController
 * @package EatingBundle\Controller
 *
 * @Route("/activity")
 */
class ActivityController extends Controller
{
    /**
     * Show list of all activity
     *
     * @return mixed
     * @Route("/", name="activity_list")
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $activity = $em->getRepository('EatingBundle:Activity')->findAll();

        return [
            'activity' => $activity
        ];
    }

    /**
     * Create new activity
     *
     * @param Request $request
     * @return mixed
     * @Route("/new", name="activity_new")
     * @Template()
     */
    public function newAction(Request $request)
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
            return $this->redirectToRoute('activity_show', ['id' => $activity->getId()]);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * Show activity
     *
     * @param Activity $activity
     * @return array
     * @Route("/{id}", name="activity_show")
     * @Template()
     */
    public function showAction(Activity $activity)
    {
        return [
            'activity' => $activity
        ];
    }

    /**
     * Edit activity
     *
     * @param Request $request
     * @param Activity $activity
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/edit", name="activity_edit")
     * @Template()
     */
    public function editAction(Request $request, Activity $activity)
    {
        $form = $this->createForm(ActivityFormType::class, $activity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();

            $this->addFlash('success', 'Activity is updated!');

            return $this->redirectToRoute('activity_show', ['id' => $activity->getId()]);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * Delete activity
     *
     * @param Activity|null $activity
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/delete", name="activity_delete")
     */
    public function deleteAction(?Activity $activity)
    {
        if (!$activity) {
            throw $this->createNotFoundException('The activity does not exist');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activity);
            $em->flush();

            $this->addFlash('success', 'Activity '.$activity->getName().' was deleted!');
        }

        return $this->redirectToRoute('activity_list');
    }
}
