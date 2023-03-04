<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneDeCommande;
use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use App\Repository\LigneDeCommandeRepository;
use App\Repository\PrestationRepository;
use App\Repository\RdvRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/commande", name="commander_")
 */
class CommandeController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, SessionInterface $session, ArticleRepository $articleRepository, PrestationRepository $prestationRepository, LigneDeCommandeRepository $ligneDeCommandeRepository, CommandeRepository $commandeRepository, RdvRepository $rdvRepository, ManagerRegistry $doctrine): Response
    {
        $title = 'Climair - Commande';   // rendu du titre de la page

        $utilisateur = $this->getUser(); // On récupère l'objet Utilisateur connecté
        if ($utilisateur) {
            $email_utilisateur = $utilisateur->getUserIdentifier(); // L'utilisateur est connecté. On récupère ses identifiants email / username
            $nom_utilisateur = $utilisateur->getNomUtilisateur();
        } else {
            return $this->redirectToRoute('app_login'); // L'utilisateur n'est pas connecté, redirection vers la page de connexion
        }

        $panier = $request->getSession()->get('panier', []); // récuperation du panier
        $total = 0; // initialisation du prix total à 0
        $article = null; // initialisation de la variable $article à null
        $prestation = null; // initialisation de la variable $article à null

        // Récupérer les articles associés à chaque élément du panier
        $articles = [];
        foreach ($panier as $id => $quantite) {
            if ($id >= 100) {
                $article = $articleRepository->find($id); // on va chercher dans le tableau $panier 
                if ($article) { // si le panier n'est pas vide
                    $article->setStock($article->getStock() - $quantite); // MàJ du stock
                    $articles[] = [ // on push dans le tableau $articles
                        'article' => $article,
                        'quantite' => $quantite
                    ];
                }
                $total += $article->getPrixArticle() * $quantite['quantite']; // calcul du prix total de la commande
            }
        }


        // Récupérer les prestations associés à chaque élément du panier
        $prestations = [];
        foreach ($panier as $id => $quantite) {
            if ($id < 100) {
                $prestation = $prestationRepository->find($id); // on va chercher dans le tableau $panier 
                if ($prestation) { // si le panier n'est pas vide
                    $prestations[] = [ // on push dans le tableau $prestations
                        'prestation' => $prestation,
                        'quantite' => $quantite
                    ];
                }

                $total += $prestation->getPrixPrestation() * $quantite['quantite']; // calcul du prix total de la prestation
            }
        }


        $entityManager = $doctrine->getManager(); // on se connecte à la BDD

        $commande = new Commande(); // instance de la classe Commande
        $date_commande = new \DateTime(); // instance de la classe \DateTime
        $commande->setDateCommande($date_commande); // on affecte à la commande la date actuelle
        $commande->setUtilisateur($utilisateur);
        $commande->setTotalCommande($total);

        $entityManager->persist($commande); // on fait persister les nouvelles données provenant du panier en BDD dans la table commande

        $ligneDeCommande = new LigneDeCommande(); // instance de la classe LigneDeCommande
        $ligneDeCommande->setCommande($commande); // On insert les clés étrangères dans la table LigneDeCommande
        // $ligneDeCommande->setQuantite($quantite); //  ""


        // $rendezVous->setStatut($statut);
        // $rendezVous->setPrestation($prestation);
        // $rendezVous->setDateRdv($date_rdv);

        if ($article) {
            $ligneDeCommande->setArticle($article); // ""
        }
        if ($prestation) {
            $ligneDeCommande->setPrestation($prestation); // ""
        }

        $session->set('panier', []);

        $entityManager->persist($ligneDeCommande); // on fait persister les données de clé étrangères en BDD dans la table LigneDeCommande
        $entityManager->flush(); // Synchronisation des changements en BDD

        return $this->render('commande/index.html.twig', compact('title', 'email_utilisateur', 'nom_utilisateur', 'articles', 'prestations', 'total', 'commande')); // on utilise la méthode Compact() pour éviter de réécrire les clés => valeurs
    }
}
