<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {

        // créer le formulaire à partir de l'instance de la classe Contact
        // car mon formulaire est lié à la classe Contact
        $contact = new Contact();
        // la classe contact est instanciée car je peux initialiser des valeurs à mes champs
        $form = $this->createForm(ContactType::class, $contact);

  
        return $this->render('contact/index.html.twig', [
            'contact_form' => $form,
        ]);
    }
}
