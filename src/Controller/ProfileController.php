<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\EditProfileFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $recentComment = $entityManager->getRepository(Comment::class)->findBy(
            ['user' => $user], 
            ['date' => 'DESC'],
            5);

        $comments = $entityManager->getRepository(Comment::class)->findBy(
            ['user' => $user],
        );

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'recentComment' => $recentComment,
            'comments' => $comments,
        ]);
    }

    #[Route('/edit_profile', name: 'app_edit_profile')]
    public function edit(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileFormType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
        
            $entityManager->persist($user);
            $entityManager->flush();

            // To avoid serialization error
            $user->setImageFile(null);

            $this->addFlash('confirmation', 'Votre profil a bien été modifié');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit.html.twig', [
            'EditProfileFormType' => $form->createView(),
        ]);
    }
}

