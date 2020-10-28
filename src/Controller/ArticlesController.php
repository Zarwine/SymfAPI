<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
