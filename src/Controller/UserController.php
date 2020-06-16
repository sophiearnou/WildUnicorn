<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**

     * Seulement le ROLE_ADMIN peut y avoir accès
     * @Route("/", name="user_index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")


     */
    // public function index(UserRepository $userRepository): Response
    // {
    //     return $this->render('user/index.html.twig', [
    //         'users' => $userRepository->findAll(),
    //     ]);
    // }

    /**

     * Seulement le ROLE_ADMIN peut y avoir accès
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")

     */
    public function new(Request $request, TranslatorInterface $translator): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash("success", $translator->trans("user.success.new", ["%title%" => $user->getEmail()]));

            return $this->redirectToRoute('admin_user');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**

     * Seulement le ROLE_ADMIN peut y avoir accès
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")

     */
    public function edit(Request $request, User $user, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", $translator->trans("user.success.edit", ["%title%" => $user->getEmail()]));
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**

     * Seulement le ROLE_ADMIN peut y avoir accès
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN')")

     */
    public function delete(Request $request, User $user, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash("success", $translator->trans("user.success.delete", ["%title%" => $user->getEmail()]));
        }

        return $this->redirectToRoute('admin_user');
    }
}
