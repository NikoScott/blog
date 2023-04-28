<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response // le retour de la méthode index() est un objet de type réponse
    // index() va intercepter une requête et retourner une réponse
    // en php 8 on peut typer le retour des méthodes
    {   
        // elle retourne l'appel à la méthode render()
        // render() => renvoit une vue
        // avec un tableau de paramètres

        // j'ai récupéré le repository de la classe Articles
        // et j'ai appelé la méthode findAll()
        $articles = $entityManager->getRepository(Articles::class)->findAll();
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('home/index.html.twig', [
            'listArticles' => $articles, // je passe des parametres à ma vue
            'listCategories' => $categories,
        ]);
    }
}