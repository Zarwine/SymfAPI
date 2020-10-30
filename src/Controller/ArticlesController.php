<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function showAllArticles(ArticleRepository $repo): Response
    {        
        $articles = $repo->findAll();

        return $this->render('articles/articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{id}", name="article")
     */
    public function showArticle(Article $article, Request $request, EntityManagerInterface $manager, CommentRepository $commentRepo): Response
    {       

        $comments = $commentRepo->findBy(["article" => $article->getId()]);
        
        return $this->render('articles/article.html.twig', [
            'article'  => $article,
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article, Request $request, EntityManagerInterface $manager, User $user)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article)
                    ->setAuthor($user);
            $manager->persist($comment);
            $manager->flush();

            $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }

        return $this->render('blog/show.html.twig', [
            "article" => $article,
            "commentForm" => $form->createView()
        ]);
    }
}
