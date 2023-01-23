<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/panier', name: 'panier_')]

class PanierController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $title = 'Climair - Panier';

        $panier = $session->get('panier', []);

        //On "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $article = $articleRepository->find($id);
            $dataPanier[] = [
                'article' => $article,
                'quantite' => $quantite
            ];
            $total += $article->getPrixArticle() * $quantite;
        }
        return $this->render('panier/index.html.twig', compact('dataPanier', 'total', 'title'));
    }

    #[Route('/add/{id}', name: 'add')]

    public function add(Article $article, SessionInterface $session): Response
    {

        // On récupère le panier actuel
        $id = $article->getId();
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier_index');
        // dd($session);
    }
    #[Route('/remove/{id}', name: 'remove')]

    public function remove(Article $article, SessionInterface $session)
    {
        $id = $article->getId();
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        // // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier_index');
        // dd($session);
    }
    #[Route('/delete/{id}', name: 'delete')]

    public function delete(Article $article, SessionInterface $session)
    {
        $id = $article->getId();
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        // // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier_index');
        // dd($session);
    }
    #[Route('/delete', name: 'delete_all')]

    public function deleteAll(SessionInterface $session)
    {

        $session->remove('panier');

        return $this->redirectToRoute('panier_index');
        // dd($session);
    }
}
