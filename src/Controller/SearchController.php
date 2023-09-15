<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry; 

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        
        $search = $request->query->get('search');

        if(is_null($search) || empty($search)){
            return $this->redirectToRoute('app_home');
            
        }
        
        $articles = $entityManager->getRepository(Articles::class)->findBySearch($search); // renvoie une liste d'article

        $datas = array();

        foreach($articles as $key =>$article){
            $datas[$key]['id'] =$article->getId();
            $datas[$key]['title'] =$article->getTitle();
            $datas[$key]['category'] =$article->getCategory()->getName();
            $datas[$key]['catchPhrase'] =$article->getCatchPhrase();
            $datas[$key]['date'] =$article->getDate()->format('d-m-Y');
            $datas[$key]['author'] =$article->getAuthor();
            $datas[$key]['description'] =$article->getDescription();
            $datas[$key]['picture'] =$article->getPicture();
            $datas[$key]['relatedSubjects'] =$article->getRelatedSubjects();
            $datas[$key]['legendMainPicture'] =$article->getLegendMainPicture();
            $datas[$key]['authorWebsite'] =$article->getAuthorWebsite();

        }

        return new Response(json_encode($datas));
    }

    #[Route('/search/articles', name: 'navbar')]
    public function getAllArticles(PersistenceManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        
        $search = null;
        // dd($request->request->get('search'));
        if (!empty($request->request->get('search'))) {

            $search = strtolower($request->request->get('search'));
            $articles = $doctrine->getRepository(Articles::class)->findBySearch($search);

            $articles = $paginator->paginate(
                $articles, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                5 /*limit per page*/
            );

            return $this->render('articles/search.html.twig', [
                'listArticles' => $articles,
                'search' => $search,
            ]);

        }

        return $this->redirectToRoute('app_home');
    }
}
