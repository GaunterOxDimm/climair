<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $title = 'Climair - Article';
        return $this->render('article/index.html.twig', compact('articles', 'title'));
    }

    #[Route('/fill', name: 'add_article')]
    public function new(): Response
    {
        return $this->render('article/index.html.twig', [
            '' => '',
        ]);
    }
}
