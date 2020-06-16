<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(EventRepository $eventRepository)
    {

        $events = $eventRepository->findWithLimit(3);
        //dd($events[0]);

        return $this->render('home/index.html.twig', [
            'events' => $events,
        ]);
    }
    /**
     * @Route("/merci", name="merci")
     */
    public function merci()
    {

        return $this->render('home/merci.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function mentions()
    {
        // return $this->render('mentions-legales/mentions-legales.html.twig', [
        //     'controller_name' => 'AppController',
        // ]);
        return $this->render('home/mentions-legales.html.twig');
    }
}
