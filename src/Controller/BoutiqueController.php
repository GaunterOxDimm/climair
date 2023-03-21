<?php

namespace App\Controller;

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
        $is_heart = $articleRepository->isHeart();

        $title = 'Climair - Boutique';
        return $this->render('boutique/index.html.twig', compact('title', 'articles', 'categories', 'is_heart'));
    }
    /**
     * @Route("/select/{id}", name="select", requirements={"id"="\d+"})
     */
    public function categorie(CategorieArticle $categorieArticle)
    {
        $articles = $categorieArticle->getArticle();
        return $this->render('boutique/index.html.twig', compact('articles'));
    }
    /**
     * @Route("/heart-add/{id}", name="heart_add", requirements={"id"="\d+"})
     */
    public function heartAdd(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->ishe();
        return $this->render('boutique/index.html.twig', compact('articles'));
    }
    /**
     * @Route("/heart-delete/{id}", name="heart_delete", requirements={"id"="\d+"})
     */
    public function heartDelete(CategorieArticle $categorieArticle)
    {
        $articles = $categorieArticle->getArticle();
        return $this->render('boutique/index.html.twig', compact('articles'));
    }
}
