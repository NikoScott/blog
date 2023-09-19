<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{

    #[Route('/comment/{id}/modify', name: 'modify_comment', requirements: ['id' => '\d+'])]
    public function modifyComment(EntityManagerInterface $entityManager, string $id, Request $request) {

        $comment = $entityManager->getRepository(Comment::class)->find($id);
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('confirmation', 'Votre commentaire a bien été modifié');
            return $this->redirectToRoute('app_profile');

        }


        return $this->render('comment/index.html.twig', [
            'comment_form' => $form->createView(),
            'comment' => $comment,
        ]);

    }

    #[Route('/comment/{id}/delete', name: 'delete_comment', requirements: ['id' => '\d+'])]
    public function deleteComment(EntityManagerInterface $entityManager, string $id, Request $request): Response
    {


        // je récupère le paramètre POST ID
        $id = $request->get('id');
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        $entityManager->remove($comment);
        $entityManager->flush();

        $this->addFlash('confirmation', 'Le commentaire a bien été supprimé !');
        return $this->redirectToRoute('app_profile');
        
    }
}