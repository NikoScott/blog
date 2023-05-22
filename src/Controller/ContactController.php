<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailService $mailService, ValidatorInterface $validator): Response
    {

        // créer le formulaire à partir de l'instance de la classe Contact
        // car mon formulaire est lié à la classe Contact
        $contact = new Contact();
        // la classe contact est instanciée car je peux initialiser des valeurs à mes champs
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);


        // if ($form->isSubmitted()) {

        //     $errors = $validator->validate($contact);

        //     if (count($errors) > 0) {
        
        //         return $this->render('contact/index.html.twig', [
        //             'contact_form' => $form,
        //             'errors' => $errors,
        //         ]);
        //     }
        // }


        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();

            $mailService->sendMail(
                [
                'firstName' => $contact->getFirstName(),
                'name' => $contact->getLastName(),
                'message' => $contact->getMessage()
                ],
                $contact->getEmail(),
                'Nouveau message !',
                'contact/email.html.twig'
            );

            $contact = new Contact();
            $form = $this->createForm(ContactType::class, $contact);

            $this->addFlash('confirmation', 'Votre email a bien été envoyé !');

        }

  
        return $this->render('contact/index.html.twig', [
            'contact_form' => $form,
        ]);
    }
}