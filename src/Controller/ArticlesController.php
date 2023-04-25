<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(): Response
    {
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }

    // route multiple
    // je récupère un article
    #[Route('/articles/{id}', name: 'show_article')]
    public function showArticle(): Response
    {
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }

}
