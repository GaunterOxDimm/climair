<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Prestation;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchResultsController extends AbstractController
{
    /**
     * @Route("/search_results", name="app_search_results")
     */
    public function search(Request $request, ArticleRepository $articleRepository): Response
    {
        $searchTerm = $request->get('search');
        $articleTrouver = $articleRepository->findNameArticle($searchTerm);
        return $this->render('search_results/index.html.twig', [
            'articleTrouver' => $articleTrouver,
            'searchTerm' => $searchTerm
        ]);
    }
}
