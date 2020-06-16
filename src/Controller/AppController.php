<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function mentions()
    {
        return $this->render('mentions-legales/mentions-legales.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
}
