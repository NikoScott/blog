<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
