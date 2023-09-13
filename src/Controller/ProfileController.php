<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }


    // a repprendre pour modifier le profile de l'utilisateur
    ////////

    // #[Route('/profile/{id}/modify', name: 'edit_user', requirements: ['id' => '\d+'])]
    // public function editProfile(EntityManagerInterface $entityManager, string $id, Request $request) {

    //     $user = $entityManager->getRepository(User::class)->find($id);
    //     $form = $this->createForm(RegistrationFormType::class, $user);

    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()) {

    //         if($file = $user->getPosterFile()) {
    //         $fileName = md5(uniqid()) . '.' . $file->guessExtension();
    //         $file->move('./profile', $fileName);

    //         $user->setPicture($fileName);
    //         }

    //         $entityManager->persist($user);
    //         $entityManager->flush();

    //         $this->addFlash('confirmation', 'Votre profil a bien été modifié');
    //         return $this->redirectToRoute('app_profile');

    //     }

    // }

}
