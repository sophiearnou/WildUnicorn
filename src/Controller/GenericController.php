<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GenericController extends AbstractController
{
    /**
     * @Route("/wildUnicorn", name="wildUnicorn")
     */
    public function index()
    {
        return $this->render('generic/index.html.twig', [
            'controller_name' => 'GenericController',
        ]);
    }
}
