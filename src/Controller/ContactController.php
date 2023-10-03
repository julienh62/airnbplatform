<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email; 
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
    {
        

        #[Route('/contact', name: 'app_contact_form')] 
        public function contactForm(Request $request, MailerInterface $mailer): Response
        {
           $form = $this->createForm(ContactType::class);
           $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
           // Récupérez les données du formulaire
            $formData = $form->getData();
            $name = $formData['name'];
            $email = $formData['email'];
            $message = $formData['message'];

            // Envoyez l'e-mail
            $email = (new Email())
                ->from($email) // Utilisez l'adresse e-mail de l'utilisateur comme expéditeur
                ->to('votre@email.com') // Remplacez par votre adresse e-mail
                ->subject('Nouvelle soumission de formulaire de contact')
                ->text('Nom: ' . $name . PHP_EOL .
                    'E-mail: ' . $email . PHP_EOL .
                    'Message: ' . $message);

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');


            // Custom confirmation message
            $confirmationMessage = 'Nous vous remercions de votre confiance. Notre équipe vous répondra très bientôt. Bien cordialement.';

            // Send a confirmation email to the user
            $userEmail = $formData['email'];
            $confirmationEmail = (new Email())
                ->from('your@email.com') // Replace with your email address
                ->to($userEmail) // Use the user's email address as the recipient
                ->subject('Confirmation de soumission de formulaire de contact')
                ->text($confirmationMessage);

            $mailer->send($confirmationEmail);


            return $this->redirectToRoute('app_contact_form');
        }

        return $this->render('contact/contact_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}   

