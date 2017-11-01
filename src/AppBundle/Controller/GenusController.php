<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use AppBundle\Repository\GenusRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenusController extends Controller
{
//    /**
//     * @Route("/genus/new")
//     */
//    public function newAction()
//    {
//        $genus = new Genus();
//        $genus->setName('Octropus'.rand(1, 100));
//        $genus->setSubFamily('Octopodinae');
//        $genus->setSpeciesCount(rand(100, 9999));
//
//        $note = new GenusNote();
//        $note->setUsername('AquaWeaver');
//        $note->setUserAvatarFilename('ryan.jpeg');
//        $note->setNote('I counted 8 legs... as they wrapped around me');
//        $note->setCreatedAt(new \DateTime('-1 month'));
//        $note->setGenus($genus);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($genus);
//        $em->persist($note);
//        $em->flush();
//
//        return new Response('<html><body>New genus created!</body></html>');
//    }

    /**
     * @Route("/genus", name="genus_list")
     */
    public function listAction()
    {
       $em = $this->getDoctrine()->getManager();
       $genuses = $em->getRepository('AppBundle:Genus')->findAllPublishedOrderedByRecentlyActive();

       return $this->render('genus/list.html.twig', [
           'genuses' => $genuses
       ]);
    }

    /**
     * @Route("/genus/{genusId}", name="genus_show")
     */
    public function showAction($genusId)
    {
        $em = $this->getDoctrine()->getManager();
        $genus = $em->getRepository('AppBundle:Genus')->findOneBy(['id' => $genusId]);

        if (!$genus) {
            throw $this->createNotFoundException('genus not found');
        }
        // todo - add the caching back later
        /*
        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($funFact);
        if ($cache->contains($key)) {
            $funFact = $cache->fetch($key);
        } else {
            sleep(1); // fake how slow this could be
            $funFact = $this->get('markdown.parser')
                ->transform($funFact);
            $cache->save($key, $funFact);
        }
        */

        $recentNotes = $em->getRepository('AppBundle:GenusNote')
            ->findAllRecentNotesForGenus($genus);

        return $this->render('genus/show.html.twig', array(
            'genus' => $genus,
            'recentNoteCount' => count($recentNotes)
        ));
    }

    /**
     * @Route("/genus/{id}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction(Genus $genus) {
        $notes = [];

        foreach ($genus->getNotes() as $note) {
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUsername(),
                'avatarUri' => '/images/'.$note->getUserAvatarFilename(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y')
            ];
        }

        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }

}