<?php

namespace App\Controller;

use App\Repository\CategorieArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieArticleController extends AbstractController
{
    #[Route('/categorie/article', name: 'app_categorie_article')]
    public function index(): Response
    {
        return $this->render('categorie_article/index.html.twig', [
            'controller_name' => 'CategorieArticleController',
        ]);
    }

    #[Route('/find/{id}', name: 'find_by_cat')]

    public function search(CategorieArticleRepository $categorieArticleRepository): Response
    {
        $categorieArticle = $categorieArticleRepository->findAll();
        return $this->render('boutique/index.html.twig', [
            'categorieArticle' => $categorieArticle
        ]);
    }
}
