<?php

namespace App\Controller;

use App\Entity\CategorieArticle;
use App\Repository\ArticleRepository;
use App\Repository\CategorieArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/boutique', name: 'boutique_')]
class BoutiqueController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArticleRepository $articleRepository, CategorieArticleRepository $categorieArticleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $categorie = $categorieArticleRepository->findAll();
        $title = 'Climair - Boutique';
        return $this->render('boutique/index.html.twig', [
            'articles' => $articles,
            'title' => $title,
            'categorie' => $categorie
        ]);
    }
}
