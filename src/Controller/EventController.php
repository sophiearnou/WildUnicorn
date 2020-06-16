<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     * 
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    /**
     * Seul ROLE_ADMIN peut accéder à new
     * @Route("/new", name="event_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function new(Request $request, TranslatorInterface $translator): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            $this->addFlash("success", $translator->trans("event.success.new", ["%title%" => $event->getTitle()]));

            return $this->redirectToRoute('admin');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="event_search", methods={"POST"})
     */
    public function search(Request $request, EventRepository $eventRepository): Response
    { //je dis au controller que je veux recupérer les info ci dessous et en suite je retourne une réponse json
        // on recupere les donnée avec la variable q qu'on a passer en paramète avec ajax
        $events = $eventRepository->findByTitle($request->request->get('q'));
        //j'initialise une variable pour le tableau json
        $json = [];
        foreach ($events as $index => $event) {
            $json[$index] = [];
            $json[$index]['title'] = $event->getTitle();
            $json[$index]['category'] = $event->getCategories()[0]->getTitle();
            $json[$index]['url'] = '/fr/event/' . $event->getId();
        }

        return new JsonResponse($json);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function detail(Event $event): Response
    {
        // dd($event);

        return $this->render('event/detail.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     * Seul ROLE_ADMIN peut accéder à edit
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Event $event, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", $translator->trans("event.success.edit", ["%title%" => $event->getTitle()]));
            

            return $this->redirectToRoute('admin');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Seul ROLE_ADMIN peut accéder à edit
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Event $event, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $this->render("event/show.html.twig");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
            $this->addFlash("success", $translator->trans("event.success.delete", ["%title%" => $event->getTitle()]));
        }

        return $this->redirectToRoute('admin');
    }
}
