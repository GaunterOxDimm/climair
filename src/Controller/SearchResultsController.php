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
        // votre code pour exécuter la requête SQL
        $query = "
            SELECT DISTINCT *
            FROM ligne_de_commande lc
            INNER JOIN article a ON lc.article_id = a.id
            INNER JOIN prestation p ON lc.prestation_id = p.id
            WHERE LOWER(a.nom_article) LIKE :search OR LOWER(p.nom) LIKE :search
        ";


        dump($query); // Affiche la requête SQL générée

        $results = $connection->executeQuery($query, ['search' => '%' . strtolower($search) . '%']);

        $resultsArray = $results->fetchAllAssociative();

        dump($resultsArray); // Affiche le tableau de résultats

        return $this->render('search_results/index.html.twig', [
            'results' => $resultsArray,
        ]);
    }
}
