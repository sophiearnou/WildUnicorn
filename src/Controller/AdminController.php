<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
*/
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index(EventRepository $er)
    {
        return $this->render('admin/index.html.twig', [
            'events' => $er->findAll(),
        ]);
    }

    /**
     * @Route("/category", name="admin_category", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexCategory(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/index_category.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/image", name="admin_image", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexImage(ImageRepository $imageRepository): Response
    {
        return $this->render('admin/index_image.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    /**
     * Seulement le ROLE_ADMIN peut y avoir accès
     * @Route("/user", name="admin_user", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexUser(UserRepository $userRepository): Response
    {
        return $this->render('admin/index_user.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
