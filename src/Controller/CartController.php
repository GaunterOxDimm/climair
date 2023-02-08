<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\LigneDeCommande;
use App\Repository\ArticleRepository;
use App\Repository\LigneDeCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="index")]
     */
    public function index(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $panier = $session->get('panier', []);

        // On fabrique les données du panier

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

        return $this->render('cart/index.html.twig', compact('dataPanier', 'total'));
    }
    /**
     * @Route("/add/{id}", name="add", requirements={"id"="\d+"})
     */
    public function add(Article $article, SessionInterface $session)
    {
        // on récupère le panier actuel

        $panier = $session->get('panier', []);
        $id = $article->getId();
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/remove/{id}", name="remove", requirements={"id"="\d+"})
     */
    public function remove(Article $article, SessionInterface $session)
    {
        // on récupère le panier actuel

        $panier = $session->get('panier', []);
        $id = $article->getId();
        if (!empty($panier[$id])) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }

        // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/delete_all", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        // on récupère le panier actuel

        $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/delete_one/{id}", name="delete_one", requirements={"id"="\d+"})
     */
    public function deleteOne(Article $article, SessionInterface $session)
    {
        // on récupère le panier actuel

        $panier = $session->get('panier', []);
        $id = $article->getId();
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/commander", name="commande")
     */
    public function commander(SessionInterface $session, ArticleRepository $articleRepository, EntityManagerInterface $em)
    {
        $panier = $session->get('panier', []);
        foreach ($panier as $id => $quantite) {
            $article = $articleRepository->find($id);
            $article->setStock($article->getStock() - $quantite);
            $em->flush();

            // if ($stock < $quantite) {
            //     return $this->redirectToRoute('cart_index', [], Response::HTTP_BAD_REQUEST);
            // }
        }
        return $this->redirectToRoute('commander_index');
    }
}
