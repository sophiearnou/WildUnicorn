<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer, TranslatorInterface $translator): Response
    {
        // dd($request->request->all());
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            // dd($contactFormData);
            $message = (new \Swift_Message('You Got Mail!'))
                ->setFrom($contactFormData['email'])
                ->setTo("nepasrepondre@wildunicorn.com")
                ->setBody(
                    $contactFormData['message'],
                    'text/plain'
                );

            $mailer->send($message);

            $this->addFlash("success", $translator->trans("contact.success"));





            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
