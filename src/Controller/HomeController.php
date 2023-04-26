<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response // le retour de la méthode index() est un objet de type réponse
    // index() va intercepter une requête et retourner une réponse
    // en php 8 on peut typer le retour des méthodes
    {   
        // elle retourne l'appel à la méthode render()
        // render() => renvoit une vue
        // avec un tableau de paramètres

        // j'ai récupéré le repository de la classe Articles
        // et j'ai appelé la méthode findAll()
        $products = $entityManager->getRepository(Articles::class)->findAll();

        // dd($products);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
