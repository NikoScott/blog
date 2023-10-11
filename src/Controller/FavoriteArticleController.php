<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteArticleController extends AbstractController
{
    #[Route('/favorite/article', name: 'app_favorite_article')]
    public function index(): Response
    {
        return $this->render('favorite_article/index.html.twig', [
            'controller_name' => 'FavoriteArticleController',
        ]);
    }
}
