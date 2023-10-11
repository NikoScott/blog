<?php

namespace App\Controller;

use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsLetterController extends AbstractController
{


    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('newsletter');
            $frequence = $request->request->get('frequence');
    
            // Valide les données et enregistre dans entité Newsletter
            $newsletter = new Newsletter();
            $newsletter->setEmail($email);
            $newsletter->setFrequence($frequence);
    
            $entityManager->persist($newsletter);
            $entityManager->flush();
    
            // Message flash de confirmation
            $this->addFlash('confirmation', 'Votre inscription à la newsletter est faite.');
            return $this->render('home/index.html.twig');
        }
    
        return $this->render('newsletter/index.html.twig', []);
    }
    
}