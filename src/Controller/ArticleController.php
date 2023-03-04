<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/article", name="article_")
 */
class ArticleController extends AbstractController
{

    /**
     * @Route("/article/{id}", name="index", requirements={"id"="\d+"})
     */
    public function index(ArticleRepository $articleRepository, Article $article): Response
    {
        $id_article = $article->getId();
        $articleChoisi = $articleRepository->find($id_article);
        $articles = $articleRepository->findAllExcept($article);
        $title = 'Climair - Article';
        return $this->render('article/index.html.twig', compact('articleChoisi', 'title', 'articles'));
    }
}
