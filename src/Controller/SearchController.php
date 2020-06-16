<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(EventRepository $eventRepository): Response
    {
        // Je récupère le contenu de mma variable q
        //je fais un appel sur l'entitée Event
        //Je récupère tout les évènements et je retourne le tout au format JSON
        return ([]);
    }
}
