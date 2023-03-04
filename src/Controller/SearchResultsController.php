<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Prestation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchResultsController extends AbstractController
{
    /**
     * @Route("/search", name="search_results")
     */
    public function search(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchTerm = $request->request->get('search');

        $articles = $entityManager->getRepository(Article::class)->createQueryBuilder('a')
            ->where('a.nom_article LIKE :search')
            ->setParameter('search', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();

        $prestations = $entityManager->getRepository(Prestation::class)->createQueryBuilder('p')
            ->where('p.nom LIKE :search')
            ->setParameter('search', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();

        return $this->render('search_results/index.html.twig', [
            'articles' => $articles,
            'prestations' => $prestations,
            'searchTerm' => $searchTerm
        ]);
    }
}
