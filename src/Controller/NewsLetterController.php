<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Newsletter;
use App\Entity\User;
use App\Form\EditProfileFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManager;
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

        return $this->render('newsletter/index.html.twig', [


        ]);
    }
}

