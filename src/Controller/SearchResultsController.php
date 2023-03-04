<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/search", name="search_")
 */
class SearchResultsController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('search_results/index.html.twig', [
            'controller_name' => 'SearchResultsController',
        ]);
    }

    /**
     * @Route("/results", name="results")
     */
    public function searchResults(Request $request, Connection $connection)
    {
        $search = $request->request->get('search');

        $query = "
        SELECT nom_article FROM article
        WHERE nom_article LIKE :search
        UNION
        SELECT nom FROM prestation
        WHERE nom LIKE :search
    ";

        $results = $connection->executeQuery($query, ['search' => '%' . strtolower($search) . '%']);

        $resultsArray = [];
        while ($row = $results->fetchAssociative()) {
            $resultsArray[] = $row['nom_article'] ?? $row['nom'];
        }

        return $this->render('search_results/index.html.twig', [
            'results' => $resultsArray,
        ]);
    }
}
