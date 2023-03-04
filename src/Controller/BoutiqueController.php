<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\CategorieArticle;
use App\Repository\ArticleRepository;
use App\Repository\PrestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/boutique", name="boutique_")
 */
class BoutiqueController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */

    public function index(ArticleRepository $articleRepository, CategorieArticleRepository $categorieArticleRepository, PrestationRepository $prestationRepository, EntityManagerInterface $entityManager, Request $request, $categorie = null): Response
    {

        $categories = $categorieArticleRepository->findAll();
        $articles = $articleRepository->findAll();

        $title = 'Climair - Boutique';
        return $this->render('boutique/index.html.twig', compact('title', 'articles', 'categories'));
    }
    /**
     * @Route("/select/{id}", name="select", requirements={"id"="\d+"})
     */
    public function categorie(CategorieArticle $categorieArticle)
    {
        $articles = $categorieArticle->getArticle();
        return $this->render('boutique/index.html.twig', compact('articles'));
    }
}
