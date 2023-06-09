<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response // le retour de la méthode index() est un objet de type réponse
    // index() va intercepter une requête et retourner une réponse
    // en php 8 on peut typer le retour des méthodes
    {   
        // elle retourne l'appel à la méthode render()
        // render() => renvoit une vue
        // avec un tableau de paramètres

        // j'ai récupéré le repository de la classe Articles
        // et j'ai appelé la méthode findAll()
        $articles = $entityManager->getRepository(Articles::class)->findBy([], ['date' => 'DESC']);

        // $categories = $entityManager->getRepository(Category::class)->findAll();
        $categories = $entityManager->getRepository(Category::class)->findCategoriesWithArticles();

        // je remplace article par pagination
        $articles = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
    );

        return $this->render('home/index.html.twig', [
            'listArticles' => $articles, // je passe des parametres à ma vue
            'listCategories' => $categories,
        ]);
    }
}
