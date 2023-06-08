<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\Comment;
use App\Form\ArticlesType;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(Request $request): Response
    {

        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }

    #[Route('/article/{id}/delete', name: 'delete_article', requirements: ['id' => '\d+'])]
    public function deleteArticle(EntityManagerInterface $entityManager, string $id, Request $request): Response
    {
        // je récupère le paramètre POST ID
        $id = $request->get('id');
        $article = $entityManager->getRepository(Articles::class)->find($id);

        if($picture = $article->getPicture()) {
            @unlink('./images/articles/' . $picture);
        }

        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('confirmation', 'L\'article a bien été supprimé !');
        return $this->redirectToRoute('app_home');
        
    }

    // route multiple
    // je récupère un article
    #[Route('/article/{id}', name: 'show_article_by_id', requirements: ['id' => '\d+'])]
    public function showArticle(EntityManagerInterface $entityManager, string $id, Request $request): Response
    {

        // récupérer l'article en bdd avec l'id de mon article
        // comment récupérer l'id (qui est param dans l'url)
        // je récupère le paramètre id via l'argument $id

        $article = $entityManager->getRepository(Articles::class)->findBy(["id" => $id ])[0];
        
        $relatedArticles = $entityManager->getRepository(Articles::class)->findLastThreeRelatedArticles($article->getCategory(), $id);

        // récupérer les commentaires valides pour cet article
        $comments = $entityManager->getRepository(Comment::class)->findValidComments($article);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $comment->setArticle(($article));
            $comment->setDate(new \DateTime);
            $comment->setUser($this->getUser());
            $comment->setApprouved(false);

            $entityManager->persist($comment);
            $entityManager->flush();

            // réinitialiser le formulaire
            $comment = new Comment();
            $form = $this->createForm(CommentType::class, $comment);
    
            $this->addFlash('confirmation', 'Votre commentaire sera prochainement validé');

        }

        return $this->render('articles/article.html.twig', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'form_comment' => $form,
            'comments' => $comments
        ]);
    }

    /**
     * Cette méthode permet d'afficher tous les articles liés à une catégorie
     */
    #[Route('/articles/{id}/', name: 'show_articles_by_category', requirements: ['id' => '\d+'])]
    public function showArticlesByCategory(EntityManagerInterface $entityManager, string $id): Response
    {

        $articles = $entityManager->getRepository(Articles::class)->findBy(["category" => $id ], ['date' => 'DESC']);
        $category = $entityManager->getRepository(Category::class)->find($id);

        return $this->render('articles/index.html.twig', [
            'listArticles' => $articles,
            'category' => $category->getName(),
        ]);
    }

    /**
     * CETTE MÉTHODE PERMET DE MODIFIER UN ARTICLE
     */
    #[Route('/article/{id}/modify', name: 'modify_article', requirements: ['id' => '\d+'])]
    public function modifyArticle(EntityManagerInterface $entityManager, string $id, Request $request) {

        $article = $entityManager->getRepository(Articles::class)->find($id);
        $form = $this->createForm(ArticlesType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if($file = $article->getPosterFile()) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move('./images/articles', $fileName);

            $article->setPicture($fileName);
            }

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('confirmation', 'Votre article a bien été modifié en BDD');
            return $this->redirectToRoute('app_home');

        }


        return $this->render('articles/modify.html.twig', [
            'articles_form' => $form->createView(),
            'article' => $article,
        ]);

    }

    /**
     * CETTE METHODE PERMET DE CREER UN ARTICLE
     */
    #[Route('/articles/ajout', name: 'ajout_article', )]
    public function ajouterArticle(EntityManagerInterface $entityManager, Request $request): Response
    {
    
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);            
        $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()) {

                // si j'ai une categorie nouvel dans le formulaire je la set en BDD

                if(!is_null($form->get('newCategory')->getData()) && !empty($form->get('newCategory')->getData())) {

                    $category = new Category();
                    $category->setName($form->get('newCategory')->getData());
                    $category->setDescription("");

                    $entityManager->persist($category);
                    $article->setCategory($category);
                }
  

                // sinon je choisis dans la liste donc dessous

                if($file = $article->getPosterFile()) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move('./images/articles', $fileName);
    
                $article->setPicture($fileName);
                }
    
                $entityManager->persist($article);
                $entityManager->flush();
    
                $this->addFlash('confirmation', 'Votre article a bien été ajouté en BDD');
                return $this->redirectToRoute('app_home');
    
            }
    
            return $this->render('articles/ajout.html.twig', [
                'add_articles_form' => $form->createView(),
                'article' => $article,
            ]);
    }
    
}